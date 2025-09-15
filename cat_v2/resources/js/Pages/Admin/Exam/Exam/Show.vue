<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Latihan Soal</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Latihan Soal</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Latihan Soal</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link href="/admin/exams" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <th width="350px">Kategori</th>
                                <td width="10px">:</td>
                                <td>{{ exam.category.name }}</td>
                            </tr>
                            <tr>
                                <th>Sub Peminatan</th>
                                <td>:</td>
                                <td>
                                    <div v-if="exam.sub_categories.length">
                                        <div v-for="(sub_category, index) in exam.sub_categories" :key="index" style="display: inline;">
                                            <span class="badge bg-danger ms-1">{{ sub_category.name }}</span>
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
                                <th>Judul Soal</th>
                                <td>:</td>
                                <td>{{ exam.question_title.name }}</td>
                            </tr>
                            <tr>
                                <th>Judul Latihan Soal</th>
                                <td>:</td>
                                <td>{{ exam.title }}</td>
                            </tr>
                            <tr>
                                <th>Durasi</th>
                                <td>:</td>
                                <td>{{ exam.duration }} Menit</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>:</td>
                                <td>
                                    <div v-html="exam.description"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Soal Acak</th>
                                <td>:</td>
                                <td>{{ exam.random_question == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Jawaban Acak</th>
                                <td>:</td>
                                <td>{{ exam.random_answer == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Tampilkan Jawaban</th>
                                <td>:</td>
                                <td>{{ exam.show_answer == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Tampilkan Navigasi Nomor Soal</th>
                                <td>:</td>
                                <td>{{ exam.show_question_number_navigation == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Tampilkan Nomor Soal</th>
                                <td>:</td>
                                <td>{{ exam.show_question_number == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Pertanyaan Berikutnya Secara Otomatis</th>
                                <td>:</td>
                                <td>{{ exam.next_question_automatically == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Tampilkan Button Sebelum & Selanjutnya</th>
                                <td>:</td>
                                <td>{{ exam.show_prev_next_button == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Tipe Pilihan Ganda</th>
                                <td>:</td>
                                <td>{{ exam.type_option ==  1 ? 'Button option dan soal menyatu (Normal)' : 'Button option ke samping & jawaban menyatu dengan soal'}}</td>
                            </tr>
                            <tr>
                                <th>Maksimal Toleransi Keluar Tes</th>
                                <td>:</td>
                                <td>{{ exam.total_tolerance == null ? 'Tidak ada' : exam.total_tolerance + ' Kali' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="text-start">
                            <h5 class="mb-0 text-white">Ranking Pada Tes Ini</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Peringkat</th>
                                    <th>Nama</th>
                                    <th>Provinsi</th>
                                    <th>Kota</th>
                                    <th>Status</th>
                                    <th>Nilai</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center" colspan="7" v-if="!rankingExams.data.length">Data Ranking kosong</td>
                                </tr>
                                <tr v-for="(rankingExam, index) in rankingExams.data" :key="index">
                                    <td>
                                        <span class="badge bg-danger">{{ ++index + (rankingExams.current_page - 1) * rankingExams.per_page }}</span>
                                    </td>
                                    <td>{{ rankingExam.user.name }}</td>
                                    <td>{{ rankingExam.user.student && rankingExam.user.student.province ? rankingExam.user.student.province.name :  '-' }}</td>
                                    <td>{{ rankingExam.user.student && rankingExam.user.student.city ? rankingExam.user.student.city.name :  '-' }}</td>
                                    <th>
                                        <a href="#" @click.prevent="unblocked(rankingExam.id)"><span class="badge bg-danger" v-if="rankingExam.is_blocked == 1">Di Blokir, Klik Untuk Membuka</span></a>
                                        <span class="badge bg-primary" v-if="rankingExam.is_blocked == 0">Selesai Mengerjakan</span>
                                    </th>
                                    <th>{{ rankingExam.grade }}</th>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <!-- <Link class="ms-2"><i class='bx bx-grid-alt'></i></Link>
                                            <Link class="ms-2"><i class='bx bx-refresh'></i></Link> -->
                                            <a href="#" @click.prevent="destroy(rankingExam.id)" class="ms-2"><i class="bx bxs-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <Pagination :links="rankingExams.links" align="end" />
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

    //import component pagination
    import Pagination from '../../../../Components/Pagination.vue';

    //import sweet alert2
    import Swal from 'sweetalert2';

    import { Inertia } from '@inertiajs/inertia';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    export default {
        // layout
        layout: LayoutAdmin,

        // register components
        components: {
            Link,
            Head,
            Pagination
        },

        // props
        props: {
            exam: Object,
            rankingExams: Object
        },
        setup() {
            const unblocked = (id) => {
                Swal.fire({
                    title: 'Apakah Anda Yakin Akan Membuka Blokir Ujian ?',
                    text: "Setiap ujian yang dibuka blokirnya akan mengerjakan soal dari awal.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Buka Blokir'
                })
                .then((result) => {
                    if (result.isConfirmed) {

                        Inertia.get(`/admin/exams/grades/${id}/unblocked`);

                        Swal.fire({
                            title: 'Unblocked!',
                            text: 'Buka Blokir Ujian Berhasil.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            const destroy = (id) => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus'
                })
                .then((result) => {
                    if (result.isConfirmed) {

                        Inertia.delete(`/admin/exams/grades/${id}/destroy`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Nilai Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            return {
                unblocked,
                destroy
            }
        }
    }
</script>
