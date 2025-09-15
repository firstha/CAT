<template>
    <Head>
        <title>{{ $page.props.setting?.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Kelola App Showcase</title>
    </Head>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Landing Page</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kelola App Showcase</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div v-if="$page.props.flash.message" 
                 :class="`alert alert-${$page.props.flash.type} alert-dismissible fade show`" 
                 role="alert">
                {{ $page.props.flash.message }}
                <button type="button" class="btn-close" @click="$page.props.flash.message = null"></button>
            </div>

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <h4 class="mb-4">Kelola App Showcase</h4>

                    <!-- Add New Showcase -->
                    <div class="mt-5 p-3 border rounded bg-light">
                        <h5 class="mb-3">Tambah App Showcase Baru</h5>
                        <form @submit.prevent="addShowcase" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <label class="form-label">Thumbnail</label>
                                    <input 
                                        type="file" 
                                        class="form-control form-control-sm" 
                                        @change="handleThumbnailChange"
                                        accept="image/*"
                                        ref="thumbnailInput"
                                        required
                                    >
                                    <div v-if="form.errors.thumbnail" class="invalid-feedback d-block">
                                        {{ form.errors.thumbnail }}
                                    </div>
                                    <div v-if="uploadProgress > 0 && uploadProgress < 100" class="mt-2">
                                        <div class="progress">
                                            <div class="progress-bar" :style="{width: uploadProgress + '%'}"></div>
                                        </div>
                                        <small>Uploading: {{ uploadProgress }}%</small>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label">Judul</label>
                                    <input 
                                        v-model="form.title" 
                                        type="text" 
                                        class="form-control form-control-sm" 
                                        :class="{ 'is-invalid': form.errors.title }"
                                        placeholder="Judul showcase"
                                        required
                                    >
                                    <div v-if="form.errors.title" class="invalid-feedback">
                                        {{ form.errors.title }}
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea 
                                        v-model="form.description" 
                                        class="form-control form-control-sm" 
                                        :class="{ 'is-invalid': form.errors.description }"
                                        rows="2" 
                                        placeholder="Deskripsi showcase"
                                        required
                                    ></textarea>
                                    <div v-if="form.errors.description" class="invalid-feedback">
                                        {{ form.errors.description }}
                                    </div>
                                </div>
                                <div class="col-12 col-md-1 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-sm w-100" :disabled="form.processing">
                                        <span v-if="form.processing" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        <i v-else class='bx bx-plus'></i> 
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Showcases List -->
                    <div class="mt-4">
                        <h5 class="mb-3">Daftar App Showcase</h5>
                        <div v-if="showcases.length === 0" class="alert alert-info">
                            Belum ada app showcase yang ditambahkan.
                        </div>

                        <div class="list-group">
                            <div 
                                v-for="(showcase, index) in showcases" 
                                :key="showcase.id"
                                class="list-group-item mb-3 p-3 border rounded"
                                draggable="true"
                                @dragstart="dragStart(index)"
                                @dragover.prevent="dragOver(index)"
                                @drop="drop(index)"
                            >
                                <form @submit.prevent="updateShowcase(showcase)">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Thumbnail</label>
                                                <img 
                                                    :src="showcase.thumbnail_url" 
                                                    class="img-thumbnail mb-2 w-100" 
                                                    style="max-height: 150px;"
                                                    :alt="showcase.title"
                                                >
                                                <input 
                                                    type="file" 
                                                    class="form-control form-control-sm" 
                                                    @change="handleUpdateThumbnailChange($event, showcase)"
                                                    accept="image/*"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Judul</label>
                                            <input 
                                                v-model="showcase.title" 
                                                type="text" 
                                                class="form-control form-control-sm mb-2" 
                                                :class="{ 'is-invalid': updateErrors[showcase.id]?.title }"
                                                required
                                            >
                                            <div v-if="updateErrors[showcase.id]?.title" class="invalid-feedback">
                                                {{ updateErrors[showcase.id].title }}
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea 
                                                v-model="showcase.description" 
                                                class="form-control form-control-sm mb-2" 
                                                :class="{ 'is-invalid': updateErrors[showcase.id]?.description }"
                                                rows="3" 
                                                required
                                            ></textarea>
                                            <div v-if="updateErrors[showcase.id]?.description" class="invalid-feedback">
                                                {{ updateErrors[showcase.id].description }}
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-1">
                                            <div class="d-flex flex-md-column gap-2 justify-content-end h-100">
                                                <button type="submit" class="btn btn-success btn-sm" :disabled="updatingId === showcase.id">
                                                    <span v-if="updatingId === showcase.id" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    <i v-else class='bx bx-save'></i>
                                                </button>
                                                <button 
                                                    type="button" 
                                                    @click="deleteShowcase(showcase)" 
                                                    class="btn btn-danger btn-sm"
                                                    :disabled="deletingId === showcase.id"
                                                >
                                                    <span v-if="deletingId === showcase.id" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    <i v-else class='bx bx-trash'></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
        showcases: Array,
        flash: Object,
        errors: Object
    },
    data() {
        return {
            form: useForm({
                thumbnail: null,
                title: '',
                description: ''
            }),
            uploadProgress: 0,
            draggedItem: null,
            updatingId: null,
            deletingId: null,
            updateErrors: {}
        };
    },
    methods: {
        handleThumbnailChange(event) {
            this.form.thumbnail = event.target.files[0];
        },
        handleUpdateThumbnailChange(event, showcase) {
            showcase.thumbnailFile = event.target.files[0];
        },
        addShowcase() {
            this.form.post('/admin/landing-page/app-showcases', {
                preserveScroll: true,
                forceFormData: true,
                onProgress: (progress) => {
                    this.uploadProgress = Math.round(progress.percentage);
                },
                onSuccess: () => {
                    this.resetForm();
                    this.uploadProgress = 0;
                },
                onError: (errors) => {
                    console.error('Error submitting form:', errors);
                }
            });
        },
        resetForm() {
            this.form.reset();
            this.form.clearErrors();
            this.$refs.thumbnailInput.value = null;
        },
        updateShowcase(showcase) {
            this.updatingId = showcase.id;
            this.updateErrors[showcase.id] = {};
            
            const formData = new FormData();
            if (showcase.thumbnailFile) {
                formData.append('thumbnail', showcase.thumbnailFile);
            }
            formData.append('title', showcase.title);
            formData.append('description', showcase.description);

            this.$inertia.post(`/admin/landing-page/app-showcases/${showcase.id}/update`, formData, {
                preserveScroll: true,
                onSuccess: () => {
                    this.updatingId = null;
                    this.updateErrors[showcase.id] = {};
                },
                onError: (errors) => {
                    this.updateErrors[showcase.id] = errors;
                },
                onFinish: () => {
                    this.updatingId = null;
                }
            });
        },
        deleteShowcase(showcase) {
            if (confirm('Apakah Anda yakin ingin menghapus app showcase ini?')) {
                this.deletingId = showcase.id;
                this.$inertia.delete(`/admin/landing-page/app-showcases/${showcase.id}`, {
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
                const showcases = [...this.showcases];
                const draggedItem = showcases[this.draggedItem];

                showcases.splice(this.draggedItem, 1);
                showcases.splice(index, 0, draggedItem);

                this.draggedItem = index;
                this.$emit('update:showcases', showcases);
            }
        },
        drop() {
            const showcaseIds = this.showcases.map(showcase => showcase.id);

            this.$inertia.post('/admin/landing-page/app-showcases/update-order', {
                showcases: showcaseIds
            }, {
                preserveScroll: true
            });
        }
    },
    watch: {
        '$page.props.flash.message': {
            handler(newMessage) {
                if (newMessage) {
                    setTimeout(() => {
                        this.$page.props.flash.message = null;
                    }, 5000);
                }
            },
            immediate: true
        }
    }
};
</script>

<style scoped>
.card {
    border-radius: 10px;
}
.form-control, .form-control-sm {
    border-radius: 5px;
}
.alert {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    min-width: 300px;
    animation: fadeIn 0.3s, fadeOut 0.5s 4.5s;
}
.btn-close {
    padding: 0.5rem 0.5rem;
    margin-left: 1rem;
}
.list-group-item {
    cursor: move;
    transition: all 0.3s;
}
.list-group-item:hover {
    background-color: #f8f9fa;
}
.progress {
    height: 10px;
    border-radius: 5px;
    background-color: #e9ecef;
}
.progress-bar {
    background-color: #4e73df;
    transition: width 0.3s ease;
}
.spinner-border {
    display: inline-block;
    vertical-align: middle;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .card-body {
        padding: 1rem;
    }
    .list-group-item {
        padding: 1rem;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .img-thumbnail {
        max-height: 120px !important;
    }
}

@media (max-width: 768px) {
    .page-breadcrumb {
        flex-direction: column;
        align-items: flex-start;
    }
    .breadcrumb-title {
        margin-bottom: 0.5rem;
    }
    .form-label {
        font-size: 0.875rem;
    }
    .d-flex.gap-2 {
        gap: 0.5rem !important;
    }
    textarea {
        min-height: 100px;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 0.75rem;
    }
    .list-group-item {
        padding: 0.75rem;
    }
    .btn-sm {
        min-width: 32px;
        padding: 0.25rem;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-sm i {
        font-size: 1rem;
        margin: 0;
    }
    .form-control, .form-control-sm {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
    }
    .img-thumbnail {
        max-height: 100px !important;
    }
    h4, h5 {
        font-size: 1.25rem;
    }
    .d-flex.flex-md-column {
        flex-direction: row !important;
    }
}

/* Button styling */
.btn-sm i {
    margin-right: 0;
}
.flex-md-column {
    gap: 0.5rem;
}
</style>