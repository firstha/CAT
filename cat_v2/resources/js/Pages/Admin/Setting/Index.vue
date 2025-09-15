<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Setting</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Setting</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Setting</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <form @submit.prevent="submit" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Aplikasi</label>
                            <input type="text" class="form-control" v-model="form.app_name" :class="{ 'is-invalid': errors.app_name }" placeholder="Nama Aplikasi">
                            <div v-if="errors.app_name" class="invalid-feedback">
                                {{ errors.app_name }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Link</label>
                            <input type="text" class="form-control" v-model="form.app_url" :class="{ 'is-invalid': errors.app_url }" placeholder="Link">
                            <div v-if="errors.app_url" class="invalid-feedback">
                                {{ errors.app_url }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nomor Whatsapp</label>
                            <input type="text" class="form-control" v-model="form.whatsapp_number" :class="{ 'is-invalid': errors.whatsapp_number }" placeholder="Nomor Whatsapp">
                            <div v-if="errors.whatsapp_number" class="invalid-feedback">
                                {{ errors.whatsapp_number }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Token Whatsapp (Untuk Notifikasi)</label>
                            <input type="text" class="form-control" v-model="form.whatsapp_token" :class="{ 'is-invalid': errors.whatsapp_token }" placeholder="Token Whatsapp">
                            <div v-if="errors.whatsapp_token" class="invalid-feedback">
                                {{ errors.whatsapp_token }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" v-model="form.address" :class="{ 'is-invalid': errors.address }" placeholder="Alamat" rows="5"></textarea>
                            <div v-if="errors.address" class="invalid-feedback">
                                {{ errors.address }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Logo</label>
                            <input type="file" class="form-control" @input="form.logo = $event.target.files[0]" :class="{ 'is-invalid': errors.logo }" placeholder="logo">
                            <div v-if="errors.logo" class="invalid-feedback">
                                {{ errors.logo }}
                            </div>
                            <br>
                            <div v-if="setting.logo">
                                <img  v-bind:src="'/storage/upload_files/settings/' + setting.logo" style="width:120px;"/>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <label class="form-label">Nama Tertanda (Tanda Tangan)</label>
                            <input type="text" class="form-control" v-model="form.signed_name" :class="{ 'is-invalid': errors.signed_name }" placeholder="Nama Tertanda">
                            <div v-if="errors.signed_name" class="invalid-feedback">
                                {{ errors.signed_name }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Gambar Tanda Tangan</label>
                            <input type="file" class="form-control" @input="form.signed_image = $event.target.files[0]" :class="{ 'is-invalid': errors.signed_image }" placeholder="signed_image">
                            <div v-if="errors.signed_image" class="invalid-feedback">
                                {{ errors.signed_image }}
                            </div>
                            <br>
                            <div v-if="setting.signed_image">
                                <img  v-bind:src="'/storage/upload_files/settings/' + setting.signed_image" style="width:120px;"/>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="for m-label">Aktifkan Verifikasi User</label>
                            <select v-model="form.add_activation_user" :class="{ 'is-invalid': errors.add_activation_user }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                            <div v-if="errors.add_activation_user" class="invalid-feedback">
                                {{ errors.add_activation_user }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Aktifkan Pembelian Voucher</label>
                            <select v-model="form.add_voucher_purchase" :class="{ 'is-invalid': errors.add_voucher_purchase }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                            <div v-if="errors.add_voucher_purchase" class="invalid-feedback">
                                {{ errors.add_voucher_purchase }}
                            </div>
                        </div>
                        <div class="col-12" v-if="form.add_voucher_purchase == 1">
                            <label class="form-label">Tampilkan Kategori Sesuai Pembelian</label>
                            <select v-model="form.display_purchase_category" :class="{ 'is-invalid': errors.display_purchase_category }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Ya, Tampilkan Sesuai Data Pembelian</option>
                                <option value="0">Tidak, Kategori Ditampilkan Semuanya</option>
                            </select>
                            <div v-if="errors.display_purchase_category" class="invalid-feedback">
                                {{ errors.display_purchase_category }}
                            </div>
                        </div>
                        <div class="col-12" >
                            <label class="form-label">Akses Login</label>
                            <select v-model="form.login_type" :class="{ 'is-invalid': errors.login_type }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Email</option>
                                <option value="2">Username</option>
                                <option value="3">Email / Username</option>
                            </select>
                            <div v-if="errors.login_type" class="invalid-feedback">
                                {{ errors.login_type }}
                            </div>
                        </div>
                        <div class="mb-4">
                        <label for="theme" class="block text-sm font-medium text-gray-700 mb-1">
                            Pilih Tema Landing Page
                        </label>
                        <select v-model="form.theme" id="theme" name="theme" class="form-select w-full border rounded p-2">
                            <option value="1">Tema 1</option>
                            <option value="2">Tema 2</option>
                        </select>
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
    import LayoutAdmin from '../../../Layouts/Layout.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    //import reactive
    import { reactive } from 'vue';

    // import Swal
    import Swal from 'sweetalert2';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    import { Inertia } from '@inertiajs/inertia';

    export default {
        // layout
        layout: LayoutAdmin,

        // register components
        components: {
            Link,
            Head,
        },

        //props
        props: {
            errors: Object,
            setting: Object
        },

        // initialization composition API
        setup(props) {
            const form = reactive({
                app_name: props.setting.app_name,
                app_url: props.setting.app_url,
                whatsapp_number: props.setting.whatsapp_number,
                whatsapp_token: props.setting.whatsapp_token,
                logo: props.setting.logo,
                signed_name: props.setting.signed_name,
                signed_image: props.setting.signed_image,
                address: props.setting.address,
                add_activation_user: props.setting.add_activation_user ?? '',
                add_voucher_purchase: props.setting.add_voucher_purchase ?? '',
                display_purchase_category: props.setting.display_purchase_category ?? '',
                login_type: props.setting.login_type ?? '',
                theme: props.setting.theme ?? 1,
            });

            // submit method
            const submit = () => {
                // send data to server
                Inertia.post(`/admin/settings`, {
                    forceFormData: true,
                    // data
                    app_name: form.app_name,
                    app_url: form.app_url,
                    whatsapp_number: form.whatsapp_number,
                    whatsapp_token: form.whatsapp_token,
                    signed_name: form.signed_name,
                    signed_image: form.signed_image,
                    logo: form.logo,
                    address: form.address,
                    add_activation_user: form.add_activation_user,
                    add_voucher_purchase: form.add_voucher_purchase,
                    display_purchase_category: form.display_purchase_category,
                    login_type: form.login_type,
                    theme: form.theme
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Setting Berhasil Diupdate!.',
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
            }
        }
    }
</script>
