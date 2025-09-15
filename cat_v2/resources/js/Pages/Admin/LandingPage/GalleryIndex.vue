<template>
    <Head>
        <title>{{ $page.props.setting?.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Kelola Galeri</title>
    </Head>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Landing Page</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item">
                                <a href="/admin/dashboard"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Kelola Galeri</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div v-if="$page.props.flash?.message" 
                :class="`alert alert-${$page.props.flash?.type ?? 'info'} alert-dismissible fade show`" 
                role="alert">
                {{ $page.props.flash?.message }}
                <button type="button" class="btn-close" @click="$page.props.flash.message = null"></button>
            </div>

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <h4 class="mb-4">Kelola Galeri</h4>

                    <!-- Tambah Galeri -->
                    <div class="mt-4 p-3 border rounded bg-light">
                        <h5 class="mb-3">Posting Konten</h5>
                        <form @submit.prevent="addGallery" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Gambar</label>
                                    <input 
                                        type="file" 
                                        class="form-control form-control-sm" 
                                        @change="handleImageChange"
                                        accept="image/*"
                                        ref="imageInput"
                                        required
                                    >
                                    <div v-if="form.errors.image" class="invalid-feedback d-block">
                                        {{ form.errors.image }}
                                    </div>
                                    <div v-if="uploadProgress > 0 && uploadProgress < 100" class="mt-2">
                                        <div class="progress">
                                            <div class="progress-bar" :style="{width: uploadProgress + '%'}"></div>
                                        </div>
                                        <small>Uploading: {{ uploadProgress }}%</small>
                                    </div>
                                </div>
                                <div class="col-12 col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-sm w-100" :disabled="form.processing">
                                        <span v-if="form.processing" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        <i v-else class='bx bx-plus'></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Daftar Galeri -->
                    <div class="mt-4">
                        <h5 class="mb-3">Daftar Galeri</h5>
                        <div v-if="galleries.length === 0" class="alert alert-info">
                            Belum ada gambar galeri yang ditambahkan.
                        </div>

                        <div class="row g-3">
                            <div 
                                v-for="(gallery, index) in galleries" 
                                :key="gallery.id"
                                class="col-6 col-md-3"
                                draggable="true"
                                @dragstart="dragStart(index)"
                                @dragover.prevent="dragOver(index)"
                                @drop="drop(index)"
                            >
                                <div class="border rounded p-2 text-center">
                                    <img 
                                        :src="gallery.image_url" 
                                        class="img-fluid mb-2 rounded" 
                                        style="max-height: 150px; object-fit: cover;"
                                        :alt="'Gallery ' + gallery.id"
                                    >
                                    <input 
                                        type="file" 
                                        class="form-control form-control-sm mb-2" 
                                        @change="handleUpdateImageChange($event, gallery)"
                                        accept="image/*"
                                    >
                                    <div class="d-flex justify-content-center gap-2">
                                        <button 
                                            class="btn btn-success btn-sm"
                                            @click.prevent="updateGallery(gallery)"
                                            :disabled="updatingId === gallery.id"
                                        >
                                            <span v-if="updatingId === gallery.id" class="spinner-border spinner-border-sm"></span>
                                            <i v-else class="bx bx-save"></i>
                                        </button>
                                        <button 
                                            class="btn btn-danger btn-sm"
                                            @click.prevent="deleteGallery(gallery)"
                                            :disabled="deletingId === gallery.id"
                                        >
                                            <span v-if="deletingId === gallery.id" class="spinner-border spinner-border-sm"></span>
                                            <i v-else class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutAdmin from '../../../Layouts/Layout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

export default {
    layout: LayoutAdmin,
    components: { Head },
    props: {
        galleries: Array,
        flash: Object,
        errors: Object
    },
    data() {
        return {
            form: useForm({
                image: null,
            }),
            uploadProgress: 0,
            draggedItem: null,
            updatingId: null,
            deletingId: null,
            updateErrors: {}
        };
    },
    methods: {
        handleImageChange(event) {
            this.form.image = event.target.files[0];
        },
        handleUpdateImageChange(event, gallery) {
            gallery.imageFile = event.target.files[0];
        },
        addGallery() {
            this.form.post('/admin/landing-page/gallery', {
                preserveScroll: true,
                forceFormData: true,
                onProgress: (progress) => {
                    this.uploadProgress = Math.round(progress.percentage);
                },
                onSuccess: () => {
                    this.resetForm();
                    this.uploadProgress = 0;
                },
            });
        },
        resetForm() {
            this.form.reset();
            this.form.clearErrors();
            this.$refs.imageInput.value = null;
        },
        updateGallery(gallery) {
            if (!gallery.imageFile) return;
            this.updatingId = gallery.id;
            this.updateErrors[gallery.id] = {};

            const formData = new FormData();
            formData.append('image', gallery.imageFile);

            this.$inertia.post(`/admin/landing-page/gallery/${gallery.id}/update`, formData, {
                preserveScroll: true,
                onSuccess: () => {
                    this.updatingId = null;
                    this.updateErrors[gallery.id] = {};
                },
                onError: (errors) => {
                    this.updateErrors[gallery.id] = errors;
                },
                onFinish: () => {
                    this.updatingId = null;
                }
            });
        },
        deleteGallery(gallery) {
            if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                this.deletingId = gallery.id;
                this.$inertia.delete(`/admin/landing-page/gallery/${gallery.id}`, {
                    preserveScroll: true,
                    onFinish: () => {
                        this.deletingId = null;
                    }
                });
            }
        },
        dragStart(index) {
            this.draggedItem = index;
        },
        dragOver(index) {
            if (this.draggedItem !== index) {
                const galleries = [...this.galleries];
                const draggedItem = galleries[this.draggedItem];

                galleries.splice(this.draggedItem, 1);
                galleries.splice(index, 0, draggedItem);

                this.draggedItem = index;
                this.$emit('update:galleries', galleries);
            }
        },
        drop() {
            const galleryIds = this.galleries.map(gallery => gallery.id);
            this.$inertia.post('/admin/landing-page/galleries/update-order', {
                galleries: galleryIds
            }, {
                preserveScroll: true
            });
        }
    }
};
</script>

<style scoped>
.img-fluid {
    border: 1px solid #ddd;
}
.progress {
    height: 10px;
}
</style>
