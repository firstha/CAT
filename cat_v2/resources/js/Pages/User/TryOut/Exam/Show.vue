<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Try Out</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Try Out</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Try Out</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <Link :href="`/user/categories/${exam.category_id}/lesson-categories/${exam.lesson_category_id}/lessons/${exam.lesson_id}/exams`" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="row">
                <div class="col-lg-12">
                    <div v-if="$page.props.session.error" class="alert alert-danger border-0">
                        <div v-html="$page.props.session.error"></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="mb-0 text-white">Informasi</h5>
                        </div>
                        <div class="card-body">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <div v-html="exam.description"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="mb-0 text-white">Deskripsi Try Out</h5>
                        </div>
                        <div class="card-body">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <th>Nama</th>
                                        <td>:</td>
                                        <td>{{ $page.props.auth.user.name }}</td>
                                    </tr>

                                    <tr>
                                        <th width="300px">Email</th>
                                        <td width="2px">:</td>
                                        <td>{{ $page.props.auth.user.email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Username</th>
                                        <td>:</td>
                                        <td>{{ $page.props.auth.user.username ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <th>Peminatan</th>
                                        <td>:</td>
                                        <td><span class="badge bg-primary">{{ exam.category.name }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Sub peminatan khusus untuk</th>
                                        <td>:</td>
                                        <td>
                                            <div v-if="exam.sub_categories.length">
                                                <div v-for="(sub_category, index) in exam.sub_categories" :key="index" style="display: inline;">
                                                    <span>{{ sub_category.name }}</span>
                                                    <span v-if="index < exam.sub_categories.length - 1">, </span>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <span>Seluruh kategori peminatan</span>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Kategori Mata Pelajaran</th>
                                        <td>:</td>
                                        <td>{{ exam.lesson_category.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <td>:</td>
                                        <td>{{ exam.lesson.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Judul Try Out</th>
                                        <td>:</td>
                                        <td>{{ exam.title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Durasi</th>
                                        <td>:</td>
                                        <td>{{ exam.duration }} Menit</td>
                                    </tr>
                                    <tr v-if="$page.props.setting && $page.props.setting.add_voucher_purchase == 1">
                                        <th>Untuk Kategori Member</th>
                                        <td>:</td>
                                        <td>
                                            <div v-if="exam.access_type == 'basic_member'">
                                                <span class="badge badge-pill bg-danger ms-1">Basic</span>
                                                <span class="badge badge-pill bg-primary ms-1">Standard</span>
                                                <span class="badge badge-pill bg-warning ms-1">Premium</span>
                                            </div>
                                            <div v-if="exam.access_type == 'standard_member'">
                                                <span class="badge badge-pill bg-primary ms-1">Standard</span>
                                                <span class="badge badge-pill bg-warning ms-1">Premium</span>
                                            </div>
                                            <div v-if="exam.access_type == 'premium_member'">
                                                <span class="badge badge-pill bg-warning ms-1">Premium</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="text-center" v-if="!grade">
                                                <Link :href="`/user/exams/${exam.id}/exam-start`" class="btn btn-sm btn-primary">Mulai Kerjakan</Link>
                                            </div>
                                            <div class="text-center" v-else-if="grade && grade.is_finished == 0">
                                                <Link :href="`/user/exams/${exam.id}/exam-start`" class="btn btn-sm btn-warning">Lanjut Mengerjakan</Link>
                                            </div>
                                            <div class="text-center" v-else-if="grade && grade.is_finished == 1 && grade.is_blocked == 0">
                                                <Link :href="`/user/grades/${grade.id}`" class="btn btn-sm btn-success m-1">Lihat Hasil</Link>
                                                <Link :href="`/user/exams/${exam.id}/grades/${grade.id}/review`" class="btn btn-sm btn-info m-1">Review</Link>
                                                <a href="#" @click.prevent="repeatExam()" class="btn btn-sm btn-primary m-1" v-if="exam.repeat_the_exam == 1">Ulangi Pengerjaan</a>
                                            </div>
                                            <div v-else class="text-center">
                                                <Link :href="`/user/grades/${grade.id}`" class="btn btn-sm btn-success m-1">Lihat Hasil</Link>
                                                <button class="btn btn-sm btn-danger m-1">Ujian Di Blokir Silakan Hubungi Admin</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    //import sweet alert2
    import Swal from 'sweetalert2';

    import { Inertia } from '@inertiajs/inertia';

    export default {
        // layout
        layout: LayoutAdmin,

        // register components
        components: {
            Link,
            Head,
        },

        // props
        props: {
            exam: Object,
            grade: Object,
        },
        setup(props) {
            const repeatExam = () => {
                Swal.fire({
                    title: 'Konfirmasi Ulangi Pengerjaan',
                    text: "Mengulangi Ujian Dapat Mempengaruhi Nilai Anda.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ulangi Ujian'
                })
                .then((result) => {
                    if (result.isConfirmed) {

                        Inertia.get(`/user/exams/${props.exam.id}/exam-start?repeat=1`);

                        Swal.fire({
                            title: 'Success!',
                            text: 'Silakan Untuk Mengerjakan Kembali.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            return {
                repeatExam
            }
        }
    }
</script>
