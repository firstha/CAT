<template>
    <Head>
        <title>{{ $page.props.setting?.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Edit Landing Page</title>
    </Head>

    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Landing Page</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kelola Hero & Fitur</li>
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

            <!-- Hero Section-->
            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <h4 class="mb-4">Edit Hero Section</h4>
                    <form @submit.prevent="updateHero">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Judul Hero</label>
                                <input 
                                    v-model="form.hero_title" 
                                    type="text" 
                                    class="form-control" 
                                    :class="{ 'is-invalid': form.errors.hero_title }"
                                    placeholder="Masukkan judul"
                                    required
                                >
                                <div v-if="form.errors.hero_title" class="invalid-feedback">
                                    {{ form.errors.hero_title }}
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label class="form-label">Deskripsi Hero</label>
                                <textarea 
                                    v-model="form.hero_description" 
                                    class="form-control" 
                                    :class="{ 'is-invalid': form.errors.hero_description }"
                                    rows="3" 
                                    placeholder="Masukkan deskripsi"
                                    required
                                ></textarea>
                                <div v-if="form.errors.hero_description" class="invalid-feedback">
                                    {{ form.errors.hero_description }}
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary px-4" :disabled="form.processing">
                                    <i class='bx bx-save mr-1'></i> 
                                    <span v-if="form.processing">Menyimpan...</span>
                                    <span v-else>Simpan Perubahan</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Features Section-->
            <div class="card border-top border-0 border-3 border-success mt-4">
                <div class="card-body">
                    <h4 class="mb-4">Kelola Fitur</h4>

                    <div class="mt-5 p-3 border rounded bg-light">
                        <h5 class="mb-3">Tambah Fitur Baru</h5>
                        <form @submit.prevent="addFeature">
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label">Judul Fitur</label>
                                    <input 
                                        v-model="newFeature.title" 
                                        type="text" 
                                        class="form-control" 
                                        :class="{ 'is-invalid': featureErrors.title }"
                                        placeholder="Fitur Baru"
                                        required
                                    >
                                    <div v-if="featureErrors.title" class="invalid-feedback">
                                        {{ featureErrors.title }}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea 
                                        v-model="newFeature.description" 
                                        class="form-control" 
                                        :class="{ 'is-invalid': featureErrors.description }"
                                        rows="2" 
                                        placeholder="Deskripsi singkat"
                                    ></textarea>
                                    <div v-if="featureErrors.description" class="invalid-feedback">
                                        {{ featureErrors.description }}
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class='bx bx-plus mr-1'></i> Tambah
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><br>

                    <div v-for="(feature, index) in features" :key="feature.id" class="mb-4 p-3 border rounded">
                        <form @submit.prevent="updateFeature(feature.id)">
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label">Judul Fitur</label>
                                    <input 
                                        v-model="feature.title" 
                                        type="text" 
                                        class="form-control" 
                                        placeholder="Fitur Unggulan"
                                        required
                                    >
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea 
                                        v-model="feature.description" 
                                        class="form-control" 
                                        rows="2" 
                                        placeholder="Deskripsi singkat"
                                    ></textarea>
                                </div>
                                <div class="col-md-2 d-flex align-items-end gap-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class='bx bx-save'></i>
                                    </button>
                                    <button type="button" @click="deleteFeature(feature.id)" class="btn btn-danger">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </div>
                        </form>
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
        landingPage: Object,
        features: Array,
        flash: Object,
        errors: Object
    },
    setup(props) {
        const form = useForm({
            hero_title: props.landingPage.hero_title,
            hero_description: props.landingPage.hero_description
        });

        return { form };
    },
    data() {
        return {
            newFeature: {
                title: '',
                description: '',
            },
            featureErrors: {
                title: '',
                description: ''
            }
        };
    },
    methods: {
        updateHero() {
            this.form.post('/admin/landing-page/hero', {
                preserveScroll: true,
                onSuccess: () => this.resetErrors()
            });
        },
        updateFeature(id) {
            const feature = this.features.find(f => f.id === id);
            this.$inertia.post(`/admin/landing-page/features/${id}`, feature, {
                preserveScroll: true,
                onSuccess: () => this.resetErrors()
            });
        },
        addFeature() {
            this.resetErrors();

            if (!this.newFeature.title.trim()) {
                this.featureErrors.title = 'Judul fitur wajib diisi';
                return;
            }

            this.$inertia.post('/admin/landing-page/features', this.newFeature, {
                preserveScroll: true,
                onSuccess: () => {
                    this.newFeature = { title: '', description: '' };
                    this.resetErrors();
                },
                onError: (errors) => {
                    if (errors.title) this.featureErrors.title = errors.title;
                    if (errors.description) this.featureErrors.description = errors.description;
                }
            });
        },
        deleteFeature(id) {
            if (confirm('Apakah Anda yakin ingin menghapus fitur ini?')) {
                this.$inertia.delete(`/admin/landing-page/features/${id}`, {
                    preserveScroll: true
                });
            }
        },
        resetErrors() {
            this.featureErrors = { title: '', description: '' };
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
