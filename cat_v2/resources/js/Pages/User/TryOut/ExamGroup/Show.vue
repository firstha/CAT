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
                    <Link :href="`/user/exam-groups/${lessonCategory.category_id}/lesson-categories/${lessonCategory.id}/exams`" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
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
                                            <div v-html="examGroup.description"></div>
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
                                        <td><span class="badge bg-primary">{{ examGroup.category.name }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Sub peminatan khusus untuk</th>
                                        <td>:</td>
                                        <td>
                                            <div v-if="examGroup.sub_categories.length">
                                                <div v-for="(sub_category, index) in examGroup.sub_categories" :key="index" style="display: inline;">
                                                    <span>{{ sub_category.name }}</span>
                                                    <span v-if="index < examGroup.sub_categories.length - 1">, </span>
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
                                        <td><span class="badge bg-success">{{ examGroup.lesson_category.name }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Judul Try Out</th>
                                        <td>:</td>
                                        <td>{{ examGroup.title }}</td>
                                    </tr>
                                    <tr v-if="$page.props.setting && $page.props.setting.add_voucher_purchase == 1">
                                        <th>Untuk Kategori Member</th>
                                        <td>:</td>
                                        <td>
                                            <div v-if="examGroup.access_type == 'basic_member'">
                                                <span class="badge badge-pill bg-danger ms-1">Basic</span>
                                                <span class="badge badge-pill bg-primary ms-1">Standard</span>
                                                <span class="badge badge-pill bg-warning ms-1">Premium</span>
                                            </div>
                                            <div v-if="examGroup.access_type == 'standard_member'">
                                                <span class="badge badge-pill bg-primary ms-1">Standard</span>
                                                <span class="badge badge-pill bg-warning ms-1">Premium</span>
                                            </div>
                                            <div v-if="examGroup.access_type == 'premium_member'">
                                                <span class="badge badge-pill bg-warning ms-1">Premium</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card border-top border-0 border-3 border-primary">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="mb-0">Detail Soal</h5>
                            <div>
                                <Link :href="`/user/exam-groups/histories`" class="btn btn-success btn-sm">Riwayat Try Out</Link>
                            </div>
                        </div>
                       
                        <div class="card-body">
                            <table class="table mb-0" v-if="examGroup.exam_group_type == 2">
                                <tr>
                                    <td align="center" colspan="3" v-if="!examGroup.exam.length">Data Tidak Tersedia</td>
                                </tr>
                                <tbody v-for="(exam, index) in examGroup.exam" :key="index">
                                    <tr>
                                        <th>No</th>
                                        <td width="2px">:</td>
                                        <td>{{ index + 1 }}</td>
                                    </tr>
                                    <tr>
                                        <th>Judul</th>
                                        <td>:</td>
                                        <td>{{ exam.title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Durasi</th>
                                        <td>:</td>
                                        <td>{{ exam.duration }} Menit {{ exam.question_title.total_section > 1 ? '/ Kolom (total '+ exam.question_title.total_section +' Kolom)' : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>:</td>
                                        <td>
                                            <div class="text-left" v-if="!exam.grade[0]">
                                                <span class="badge bg-danger">Belum Mengerjakan</span>
                                            </div>
                                            <div class="text-left" v-else-if="exam.grade[0] && exam.grade[0].is_finished == 0">
                                                <span class="badge bg-warning text-dark">Belum selesai mengerjakan</span>
                                            </div>
                                            <div class="text-left" v-else-if="exam.grade[0] && exam.grade[0].is_finished == 1 && exam.grade[0].is_blocked == 0">
                                                <span class="badge bg-primary">Sudah Mengerjakan</span>
                                            </div>
                                            <div v-else class="text-left">
                                                <span class="badge bg-danger">Ujian Di Blokir Silakan Hubungi Admin</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Action</th>
                                        <td>:</td>
                                        <td>
                                            <span class="badge bg-warning text-dark" v-if="exam.exam_status == 'inprogress' || examGroup.exam_status == 'inprogress'">Ujian In Progress</span>
                                            <span class="badge bg-warning text-dark" v-if="exam.exam_status == 'inactive' || examGroup.exam_status == 'inactive'">Ujian Tidak Aktif</span>
                                            <div v-if="exam.exam_status == 'active' && examGroup.exam_status == 'active'">
                                                <div class="text-left" v-if="!exam.grade[0]">
                                                    <Link :href="`/user/exams/${exam.id}/exam-start`" class="btn btn-sm btn-primary px-5">Mulai Kerjakan</Link>
                                                </div>
                                                <div class="text-left" v-else-if="exam.grade[0] && exam.grade[0].is_finished == 0">
                                                    <Link :href="`/user/exams/${exam.id}/exam-start`" class="btn btn-sm btn-warning px-5">Lanjut Mengerjakan</Link>
                                                </div>
                                                <div class="text-left" v-else-if="exam.grade[0] && exam.grade[0].is_finished == 1 && exam.grade[0].is_blocked == 0">
                                                    <a href="#" @click.prevent="repeatExam(exam.id)" class="btn btn-sm btn-secondary" v-if="exam.repeat_the_exam == 1">Ulangi Pengerjaan</a>
                                                    <Link :href="`/user/grades/${exam.grade[0].id}`" class="btn btn-sm btn-success px-5 mx-1">Lihat Hasil</Link>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="3">&nbsp;</th>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table mb-0" v-else>
                                <tr>
                                    <td align="center" colspan="3" v-if="!examGroup.exam.length">Data Tidak Tersedia</td>
                                </tr>
                                <tbody>
                                    <tr>
                                        <th width="250px">Tes</th>
                                        <td width="2px">:</td>
                                        <td><span class="badge bg-danger ms-1" v-for="(exam, index) in examGroup.exam" :key="index">{{ exam.title }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Durasi</th>
                                        <td>:</td>
                                        <td>{{ examGroup.duration }} Menit</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>:</td>
                                        <td>
                                            <div class="text-left" v-if="!examGroupUser">
                                                <span class="badge bg-danger">Belum Mengerjakan</span>
                                            </div>
                                            <div class="text-left" v-else-if="examGroupUser && examGroupUser.is_finished == 0">
                                                <span class="badge bg-warning text-dark">Belum selesai mengerjakan</span>
                                            </div>
                                            <div class="text-left" v-else-if="examGroupUser && examGroupUser.is_finished == 1 && examGroupUser.is_blocked == 0">
                                                <span class="badge bg-primary">Sudah Mengerjakan</span>
                                            </div>
                                            <div v-else class="text-left">
                                                <span class="badge bg-danger">Ujian Di Blokir Silakan Hubungi Admin</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Action</th>
                                        <td>:</td>
                                        <td>
                                            <span class="badge bg-warning text-dark" v-if="examGroup.exam_status == 'inprogress'">Ujian In Progress</span>
                                            <span class="badge bg-warning text-dark" v-if="examGroup.exam_status == 'inactive'">Ujian Tidak Aktif</span>
                                            <div v-if="examGroup.exam_status == 'active'">
                                                <div class="text-left" v-if="!examGroupUser">
                                                    <Link :href="`/user/exam-groups/${examGroup.id}/exam-start`" class="btn btn-sm btn-primary px-5">Mulai Kerjakan</Link>
                                                </div>
                                                <div class="text-left" v-else-if="examGroupUser && examGroupUser.is_finished == 0">
                                                    <Link :href="`/user/exam-groups/${examGroup.id}/exam-start`" class="btn btn-sm btn-warning px-5">Lanjut Mengerjakan</Link>
                                                </div>
                                                <div class="text-left" v-else-if="examGroupUser && examGroupUser.is_finished == 1 && examGroupUser.is_blocked == 0">
                                                    <a href="#" @click.prevent="repeatExamGroup(examGroup.id)" class="btn btn-sm btn-secondary" v-if="examGroup.repeat_the_exam == 1">Ulangi Pengerjaan</a>
                                                    <Link :href="`/user/exam-groups/${examGroupUser.id}/review`" class="btn btn-sm btn-info mx-1">Review</Link>
                                                </div>
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
            examGroup: Object,
            lessonCategory: Object,
            examGroupUser: Object,
        },
        setup() {
            const repeatExam = (id) => {
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
                     //   localStorage.removeItem("myAnswers");
                        Inertia.get(`/user/exams/${id}/exam-start?repeat=1`);

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

            const repeatExamGroup = (id) => {
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

                        Inertia.get(`/user/exam-groups/${id}/exam-start?repeat=1`);

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
                repeatExam,
                repeatExamGroup
            }
        }
    }
</script>
