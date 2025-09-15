<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Soal</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Soal</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <Link :href="`/user/categories/${categoryId}/lesson-categories/${lessonCategoryId}/lessons`" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                </div>
            </div>
            <!--end breadcrumb-->
            <hr/>
            <div v-if="!exams.data.length">
                <div class="row row-cols-12 row-cols-md-12 row-cols-lg-12 row-cols-xl-12">
                    <div class="col">
                        <div class="card border-bottom border-3 border-0">
                            <div class="card-body">
                                <h5 class="card-title text-center">Soal Belum Tersedia.</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" v-for="(exam, index) in exams.data" :key="index">
                    <div class="card border-bottom border-3 border-0">
                        <div class="p-2">
                            <img  v-bind:src="'/storage/upload_files/lessons/' + exam.lesson.thumbnail" class="card-img"/>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">{{ exam.title }}</h6>
                            <p class="card-text">Kerjakan Soal Sesuai Perintah Yang Ada Dalam Informasi.</p>
                            <hr>
                            <div class="text-center">
                                <p>Kategori Member</p>
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
                            </div>
                            <hr>
                            <div class="text-center">
                                <div v-if="exam.exam_status == 'active'">
                                    <Link :href="`/user/categories/${exam.category_id}/lesson-categories/${exam.lesson_category_id}/lessons/${exam.lesson_id}/exams/${exam.id}`" class="btn btn-outline-primary btn-sm px-5">Kerjakan Soal</Link>
                                </div>

                                <div v-if="exam.exam_status == 'inactive'">
                                    <button class="btn btn-outline-danger btn-sm px-5">Non-active</button>
                                </div>

                                <div v-if="exam.exam_status == 'inprogress'">
                                    <button class="btn btn-outline-success btn-sm px-5">In Progress</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="exams.data.length">
                <div class="col">
                    <Pagination :links="exams.links" align="center" />
                    <br>
                    <br>
                </div>
            </div>

            <!--end row-->
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout admin
    import LayoutUser from '../../../../Layouts/Layout.vue';

    //import component pagination
    import Pagination from '../../../../Components/Pagination.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';


    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';


    export default {
        // layout
        layout: LayoutUser,

        // register components
        components: {
            Link,
            Head,
            Pagination
        },

        // props
        props: {
            exams: Object,
            categoryId: Object,
            lessonCategoryId: Object,
            lessonId: Object,
        },
    }
</script>
