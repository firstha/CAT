<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Riwayat Try Out</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Riwayat Try Out</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Riwayat Latihan</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="text-start">
                            <h5 class="mb-0">Informasi Try Out</h5>
                        </div>
                        <div class="ms-auto">
                            <Link v-if="grade.exam_group_id" :href="`/user/exam-groups/${grade.category_id}/lesson-categories/${grade.lesson_category_id}/exams/${grade.exam_group_id}`" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                            <Link v-else href="/user/grades" class="btn btn-primary btn-sm">Kembali</Link>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <th width="170px">Peminatan</th>
                                    <td width="10px">:</td>
                                    <td><span class="badge bg-primary">{{ grade.category.name }}</span></td>
                                </tr>
                                <tr>
                                    <th>Kategori Mata Pelajaran</th>
                                    <td>:</td>
                                    <td>{{ grade.lesson_category.name }}</td>
                                </tr>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <td>:</td>
                                    <td>{{ grade.lesson.name }}</td>
                                </tr>
                                <tr>
                                    <th>Judul Ujian</th>
                                    <td>:</td>
                                    <td>{{ grade.exam.title }}</td>
                                </tr>
                                <tr>
                                    <th>Durasi</th>
                                    <td>:</td>
                                    <td>{{ grade.exam.duration }} Menit</td>
                                </tr>
                                <tr>
                                    <th>Waktu Mulai</th>
                                    <td>:</td>
                                    <td>{{ formatDateWithTime(grade.start_time) }}</td>
                                </tr>
                                <tr>
                                    <th>Waktu Selesai</th>
                                    <td>:</td>
                                    <td>{{ formatDateWithTime(grade.end_time) }}</td>
                                </tr>
                                <tr>
                                    <th>Nilai</th>
                                    <td>:</td>
                                    <td><h5>{{ grade.grade }}</h5></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="card" v-if="grade.grade_details && grade.exam.question_title.add_value_category == 1 && ( grade.exam.question_title.assessment_type == 1 || grade.exam.question_title.assessment_type == 2)">
                <div class="card-header bg-primary mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="text-start">
                            <h5 class="mb-0 text-white">Detail Nilai Per Kategori</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori Penilaian</th>
                                    <th v-if="grade.exam.question_title.total_section == 1">Total Benar</th>
                                    <th v-if="grade.exam.question_title.total_section == 1">Total Salah</th>
                                    <th>Kategori Nilai</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="grade.grade_details.length" v-for="(gradeDetail, index) in grade.grade_details" :key="index">
                                    <td>{{ ++index }}</td>
                                    <td>{{ gradeDetail.grade_category_name }}</td>
                                    <td v-if="grade.exam.question_title.total_section == 1">{{ gradeDetail.total_correct }}</td>
                                    <td v-if="grade.exam.question_title.total_section == 1">{{ gradeDetail.total_wrong }}</td>
                                    <td>{{ gradeDetail.grade_category }}</td>
                                    <td>
                                        <span v-if="grade.lesson.id == '4b1978c5-420c-454b-ba69-bd1be91ea40d'"></span>
                                        <span v-else>{{ gradeDetail.grade }}</span>
                                    </td>
                                </tr>
                                <tr v-if="grade.grade_details.length">
                                    <th v-if="grade.exam.question_title.total_section == 1" colspan="5">Nilai {{ grade.lesson.name }} (Skala 100)</th>
                                    <th v-else colspan="3">Nilai {{ grade.lesson.name }} (Skala 100)</th>
                                    <th>{{ grade.grade }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="card border-top border-0 border-3 border-primary" v-if="grade.exam.question_title.total_section > 1 && grade.total_correct_per_section">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="text-start">
                            <h5 class="mb-0">Grafik Ketahanan</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <apexchart :width="chart.width" :height="chart.height" :type="chart.type" :options="chart.options" :series="chart.series"></apexchart>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="text-start">
                            <h5 class="mb-0 text-white">Ranking di Try Out ini</h5>
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
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(rankingExam, index) in rankingExams.data" :key="index">
                                    <td>
                                        <span class="badge bg-primary">{{ ++index + (rankingExams.current_page - 1) * rankingExams.per_page }}</span>
                                    </td>
                                    <td>{{ rankingExam.user.name }}</td>
                                    <td>{{ rankingExam.user.student && rankingExam.user.student.province ? rankingExam.user.student.province.name :  '-' }}</td>
                                    <td>{{ rankingExam.user.student && rankingExam.user.student.city ? rankingExam.user.student.city.name :  '-' }}</td>
                                    <th>{{ rankingExam.grade }}</th>
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
            grade: Object,
            rankingExams: Object,
            chart: Object,
            answers: Object,
        },
    }
</script>
