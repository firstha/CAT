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
                            <li class="breadcrumb-item active" aria-current="page">Soal Try Out</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <Link :href="`/user/exam-groups/${lessonCategory.category_id}/lesson-categories`" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                </div>
            </div>
            <hr/>
            <div v-if="!examGroups.data.length">
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
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" v-for="(exam, index) in examGroups.data" :key="index">
                    <div class="card border-bottom border-3 border-0">
                        <div class="p-2">
                            <img v-bind:src="'/storage/upload_files/lesson_categories/' + exam.lesson_category.thumbnail" class="card-img" />
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-center" style="height:30px;">{{ exam.title }}</h6>
                            <hr>
                            <p class="card-text">Kerjakan Soal Sesuai Perintah Yang Ada Dalam Informasi.</p>

                            <div class="text-center"> <!-- Add this div to align the badges to the right -->
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

                                <hr>
                                <div v-if="exam.exam_status == 'active'">
                                    <Link :href="`/user/exam-groups/${lessonCategory.category_id}/lesson-categories/${lessonCategory.id}/exams/${exam.id}`" class="btn btn-sm btn-outline-primary px-5 btn-block">Selengkapnya</Link>
                                </div>

                                <div v-if="exam.exam_status == 'inactive'">
                                    <button class="btn btn-sm btn-outline-danger px-5">Non-active</button>
                                </div>

                                <div v-if="exam.exam_status == 'inprogress'">
                                    <button class="btn btn-sm btn-outline-success px-5">In Progress</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" v-if="examGroups.data.length">
                <div class="col">
                    <Pagination :links="examGroups.links" align="center" />
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
            examGroups: Object,
            lessonCategory: Object,
        },
    }
</script>
