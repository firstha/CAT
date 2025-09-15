<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Edit Voucher</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Voucher</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Voucher</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link href="/admin/vouchers" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <form @submit.prevent="submit" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Kategori Peminatan</label>
                            <select  @change="subCategoryData" v-model="form.category_id" :class="{ 'is-invalid': errors.category_id }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option v-for="(category, index) in categories" :key="index" :value="category.id">{{ category.name }}</option>
                            </select>
                            <div v-if="errors.category_id" class="invalid-feedback">
                                {{ errors.category_id }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Sub Kategori Peminatan</label>
                            <multiselect
                                v-model="form.sub_category_ids"
                                :options="form.subCategories"
                                :multiple="true"
                                label="name"
                                :close-on-select="true"
                                :allow-empty="true"
                                track-by="id"
                                placeholder="[ Pilih ]"
                            ></multiselect>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Kode</label>
                            <input type="text" class="form-control" v-model="form.code" :class="{ 'is-invalid': errors.code }" placeholder="Kode">
                            <div v-if="errors.code" class="invalid-feedback">
                                {{ errors.code }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nama Voucher</label>
                            <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': errors.name }" placeholder="Nama Voucher">
                            <div v-if="errors.name" class="invalid-feedback">
                                {{ errors.name }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Tipe Akses</label>
                            <select v-model="form.access_type" :class="{ 'is-invalid': errors.access_type }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="basic_member">Basic Member</option>
                                <option value="standard_member">Standard Member</option>
                                <option value="premium_member">Premium Member</option>
                                <option value="vip_member">VIP Member</option>
                            </select>
                            <div v-if="errors.access_type" class="invalid-feedback">
                                {{ errors.access_type }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Batasan User</label>
                            <input type="number" class="form-control" v-model="form.user_limit" :class="{ 'is-invalid': errors.user_limit }" placeholder="Batasan User">
                            <div v-if="errors.user_limit" class="invalid-feedback">
                                {{ errors.user_limit }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Tipe</label>
                            <select v-model="form.type" :class="{ 'is-invalid': errors.type }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <!-- <option value="week">Minggu</option> -->
                                <option value="month">Bulan</option>
                                <!-- <option value="year">Tahun</option> -->
                            </select>
                            <div v-if="errors.type" class="invalid-feedback">
                                {{ errors.type }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Masa Keaktifan</label>
                            <input type="number" class="form-control" v-model="form.active_period" :class="{ 'is-invalid': errors.active_period }" placeholder="Masa Keaktifan">
                            <div v-if="errors.active_period" class="invalid-feedback">
                                {{ errors.active_period }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Harga Sebelum Diskon</label>
                            <input type="number" class="form-control" v-model="form.price_before_discount" :class="{ 'is-invalid': errors.price_before_discount }" placeholder="Harga Sebelum Diskon">
                            <div v-if="errors.price_before_discount" class="invalid-feedback">
                                {{ errors.price_before_discount }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Harga Sesudah Diskon</label>
                            <input type="number" class="form-control" v-model="form.price_after_discount" :class="{ 'is-invalid': errors.price_after_discount }" placeholder="Harga Sesudah Diskon">
                            <div v-if="errors.price_after_discount" class="invalid-feedback">
                                {{ errors.price_after_discount }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <Editor
                                api-key="k1vaa8f2edr18d53tqy724pne2lxmhnot1ydy4vpgf3too81"
                                v-model="form.description"
                                :init="{
                                    images_upload_url: 'https://wakalahmu.com/admin/upload',
                                    automatic_uploads: true,
                                    height: 400,
                                    plugins: [
                                        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                                        'searchreplace wordcount visualblocks visualchars code fullscreen',
                                        'insertdatetime media nonbreaking save table contextmenu directionality',
                                        'emoticons template paste textcolor colorpicker textpattern imagetools'
                                    ],
                                    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons',
                                    image_advtab: true,
                                }"
                            />
                            <div v-if="errors.description">
                                {{ errors.description }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Status</label>
                            <select v-model="form.is_active" :class="{ 'is-invalid': errors.is_active }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                            <div v-if="errors.is_active" class="invalid-feedback">
                                {{ errors.is_active }}
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm px-5">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout admin
    import LayoutAdmin from '../../../../Layouts/Layout.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    //import reactive
    import { reactive } from 'vue';

    // import Swal
    import Swal from 'sweetalert2';

    //import tinyMCE
    import Editor from '@tinymce/tinymce-vue';

    import Multiselect from '@suadelabs/vue3-multiselect'

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    import { Inertia } from '@inertiajs/inertia';
    
    //import axios
    import axios from 'axios';

    export default {
        // layout
        layout: LayoutAdmin,

        // register components
        components: {
            Link,
            Head,
            Editor,
            Multiselect
        },

        //props
        props: {
            errors: Object,
            voucher: Object,
            categories: Object,
            subCategories: Object,
        },

        // initialization composition API
        setup(props) {
            const form = reactive({
                code: props.voucher.code,
                category_id: props.voucher.category_id,
                name: props.voucher.name,
                user_limit: props.voucher.user_limit,
                access_type: props.voucher.access_type,
                type: props.voucher.type,
                active_period: props.voucher.active_period,
                price_before_discount: props.voucher.price_before_discount,
                price_after_discount: props.voucher.price_after_discount,
                description: props.voucher.description,
                sub_category_ids: props.subCategories,
                is_active: props.voucher.is_active,

                subCategories: []
            });

            // get sub category by category id
            axios.get(`/admin/categories/${form.category_id}/sub-categories`).then(response => {
            form.subCategories = response.data;
            }).catch(error => console.error(error));

            const subCategoryData = () => {
                axios.get(`/admin/categories/${form.category_id}/sub-categories`).then(response => {
                form.sub_category_ids = [];
                form.subCategories = response.data;
                }).catch(error => console.error(error));
            }

            // submit method
            const submit = () => {
                // send data to server
                Inertia.put(`/admin/vouchers/${props.voucher.id}`, {
                    // data
                    code: form.code,
                    name: form.name,
                    category_id: form.category_id,
                    user_limit: form.user_limit,
                    type: form.type,
                    access_type: form.access_type,
                    active_period: form.active_period,
                    price_before_discount: form.price_before_discount,
                    price_after_discount: form.price_after_discount,
                    description: form.description,
                    is_active: form.is_active,
                    sub_category_ids: form.sub_category_ids,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Voucher Berhasil Diupdate!.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    },
                });
            }

            // return form state and submit method
            return {
                form,
                submit,
                subCategoryData
            }
        }
    }
</script>

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
