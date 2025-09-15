<template>
    <Head>
        <title>{{ $page.props.setting?.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Edit Highlight Fitur</title>
    </Head>

    <div class="page-wrapper">
        <div class="page-content">
            <!-- breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Landing Page</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kelola Highlight Fitur</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end breadcrumb -->

            <!-- Flash Message -->
            <div v-if="$page.props.flash.message" 
                 :class="`alert alert-${$page.props.flash.type} alert-dismissible fade show`" 
                 role="alert">
                {{ $page.props.flash.message }}
                <button type="button" class="btn-close" @click="$page.props.flash.message = null"></button>
            </div>

            <!-- Highlight Features Editor -->
            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <h4 class="mb-4">Edit Highlight Fitur</h4>
                    <form @submit.prevent="submitForm">
                        <!-- Feature 1 -->
                        <div class="mb-4 p-3 border rounded">
                            <h5>Fitur 1</h5>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="form-label">Judul</label>
                                    <input 
                                        v-model="form.title1" 
                                        type="text" 
                                        class="form-control" 
                                        :class="{ 'is-invalid': form.errors.title1 }"
                                        placeholder="Judul fitur pertama"
                                        required
                                    >
                                    <div v-if="form.errors.title1" class="invalid-feedback">
                                        {{ form.errors.title1 }}
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea 
                                        v-model="form.description1" 
                                        class="form-control" 
                                        :class="{ 'is-invalid': form.errors.description1 }"
                                        rows="3" 
                                        placeholder="Deskripsi fitur pertama"
                                        required
                                    ></textarea>
                                    <div v-if="form.errors.description1" class="invalid-feedback">
                                        {{ form.errors.description1 }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="mb-4 p-3 border rounded">
                            <h5>Fitur 2</h5>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="form-label">Judul</label>
                                    <input 
                                        v-model="form.title2" 
                                        type="text" 
                                        class="form-control" 
                                        :class="{ 'is-invalid': form.errors.title2 }"
                                        placeholder="Judul fitur kedua"
                                        required
                                    >
                                    <div v-if="form.errors.title2" class="invalid-feedback">
                                        {{ form.errors.title2 }}
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea 
                                        v-model="form.description2" 
                                        class="form-control" 
                                        :class="{ 'is-invalid': form.errors.description2 }"
                                        rows="3" 
                                        placeholder="Deskripsi fitur kedua"
                                        required
                                    ></textarea>
                                    <div v-if="form.errors.description2" class="invalid-feedback">
                                        {{ form.errors.description2 }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="mb-4 p-3 border rounded">
                            <h5>Fitur 3</h5>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="form-label">Judul</label>
                                    <input 
                                        v-model="form.title3" 
                                        type="text" 
                                        class="form-control" 
                                        :class="{ 'is-invalid': form.errors.title3 }"
                                        placeholder="Judul fitur ketiga"
                                        required
                                    >
                                    <div v-if="form.errors.title3" class="invalid-feedback">
                                        {{ form.errors.title3 }}
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea 
                                        v-model="form.description3" 
                                        class="form-control" 
                                        :class="{ 'is-invalid': form.errors.description3 }"
                                        rows="3" 
                                        placeholder="Deskripsi fitur ketiga"
                                        required
                                    ></textarea>
                                    <div v-if="form.errors.description3" class="invalid-feedback">
                                        {{ form.errors.description3 }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary px-4" :disabled="form.processing">
                            <i class='bx bx-save mr-1'></i> 
                            <span v-if="form.processing">Menyimpan...</span>
                            <span v-else>Simpan Perubahan</span>
                        </button>
                    </form>
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
        highlights: Object,
        flash: Object,
        errors: Object
    },
    setup(props) {
        const form = useForm({
            title1: props.highlights?.title1 || '',
            description1: props.highlights?.description1 || '',
            title2: props.highlights?.title2 || '',
            description2: props.highlights?.description2 || '',
            title3: props.highlights?.title3 || '',
            description3: props.highlights?.description3 || '',
        });

        return { form };
    },
    methods: {
        submitForm() {
            this.form.post('/admin/landing-page/highlights', {
                preserveScroll: true,
                onSuccess: () => {
                    // Reset form atau tindakan lainnya
                }
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
/* Gunakan style yang sama dengan Index.vue */
.card {
    border-radius: 10px;
}
.form-control {
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
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
}
</style>