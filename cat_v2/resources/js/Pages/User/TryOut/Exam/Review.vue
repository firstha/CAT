<template>
  <Head>
    <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Review Hasil Ujian</title>
  </Head>

  <nav class="navbar navbar-expand-lg navbar-light bg-white rounded fixed-top rounded-0 shadow-sm">
  <div class="container-fluid">
    <Link :href="`/user/categories/${exam?.category_id}/lesson-categories/${exam?.lesson_category_id}/lessons/${exam?.lesson_id}/exams/${exam?.id}`" class="btn btn-primary btn-sm me-3">Kembali</Link>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> 
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent1">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"> 
          <a class="nav-link" aria-current="page" href="/user/dashboard">
            <i class='bx bx-home-alt me-1'></i>Home
          </a>
        </li>
        <li class="nav-item"> 
          <Link class="nav-link" href="/logout" method="POST" as="button">
            <i class='bx bx-log-out-circle'></i>Logout
          </Link>
        </li>
      </ul>
    </div>
  </div>
</nav>


  <!-- Main Content -->
  <div class="container" style="margin-top: 100px; margin-bottom: 100px;">
    <div v-if="!isReady" class="space-y-4 animate-fade">
      <div class="h-7 w-2/3 bg-gray-100 rounded animate-pulse"></div>
      <div class="h-24 w-full bg-gray-100 rounded-lg animate-pulse"></div>
      <div class="space-y-3">
        <div class="h-20 w-full bg-gray-100 rounded-lg animate-pulse"></div>
        <div class="h-20 w-full bg-gray-100 rounded-lg animate-pulse"></div>
        <div class="h-20 w-full bg-gray-100 rounded-lg animate-pulse"></div>
      </div>
      <p class="text-center text-gray-500">Memuat data review ujian...</p>
    </div>

    <!-- Content -->
    <template v-else>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12" :class="exam.show_question_number_navigation == 1 ? 'col-lg-8' : 'col-lg-12'">
          <!-- Header -->
          <div class="card mb-4">
            <div class="card-header bg-primary text-white">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h4 class="mb-0 text-white">Pembahasan - {{ exam?.title ?? 'Review Hasil Ujian' }}</h4>
                </div>
                <div>
                  <span class="badge bg-light text-dark me-2">
                    {{ safeTotalCorrect }} / {{ totalQuestions }} benar
                  </span>
                  <span :class="getGradeColorClass(safeFinalGrade)" class="badge">
                    Nilai: {{ gradeDisplay }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <section
            v-for="(q, idx) in questions"
            :key="q.id || idx"
            class="card mb-4 shadow-sm">
            <div class="card-header bg-light">
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                  <span class="badge bg-primary me-2">{{ idx + 1 }}</span>
                  <h5 class="mb-0">Soal {{ idx + 1 }}</h5>
                </div>
                <span
                  class="badge"
                  :class="q.is_correct === 'Y' ? 'bg-success' : 'bg-danger'"
                >
                  {{ q.is_correct === 'Y' ? '✓ Benar' : '✗ Salah' }}
                </span>
              </div>
            </div>

            <div class="card-body question-content" v-html="q.question"></div>

            <div class="card-body pt-0">
              <div
                v-for="opt in getOptions(q)"
                :key="opt.number"
                class="mb-2 p-3 rounded border d-flex align-items-start"
                :class="getOptionClass(q, opt.number)"
              >
                <span class="fw-bold me-2">{{ opt.letter }}.</span>
                <div v-html="opt.text"></div>
              </div>

              <div
                v-if="q.discussion"
                class="mt-3 p-3 rounded border border-info bg-info bg-opacity-10"
              >
                <p class="fw-bold text-info mb-2">Pembahasan:</p>
                <div class="text-muted" v-html="q.discussion"></div>
              </div>

              <div
                class="mt-3 p-3 rounded border-start border-4 d-flex align-items-center"
                :class="q.is_correct === 'Y' ? 'border-info bg-info bg-opacity-10' : 'border-info bg-info bg-opacity-10'"
              >
                <div class="flex-grow-1">
                  <p class="mb-0 small">
                    Jawaban Anda:
                    <span :class="q.is_correct === 'Y' ? 'text-success fw-bold' : 'text-danger fw-bold'">
                      {{ getUserAnswerText(q) || 'Tidak dijawab' }}
                    </span>
                    <span v-if="q.is_correct === 'N'" class="ms-2">
                      • Jawaban Benar:
                      <span class="text-success fw-bold">{{ getCorrectAnswerText(q) }}</span>
                    </span>
                  </p>
                </div>
              </div>
            </div>
          </section>
        </div>

        <div v-if="exam.show_question_number_navigation == 1" class="col-md-12 col-sm-12 col-xs-12 col-lg-4">
          <div class="card sticky-top" style="top: 100px;">
            <div class="card-header text-white bg-primary">
              <div class="d-flex justify-content-between">
                <div>
                  <h5 class="mb-0 text-white">Navigasi Soal</h5>
                </div>
              </div>
            </div>
            <div class="card-body p-2" style="max-height: 400px; overflow-y: auto">
              <div class="row row-cols-5 g-2">
                <div v-for="(q, idx) in questions" :key="'nav-'+idx" class="col">
                  <button 
                    class="btn w-100 p-0 rounded"
                    :class="[
                        idx === activeQuestion ? 'btn-active' : '',
                        q.is_correct === 'Y' ? 'btn-success-00' : q.is_correct === 'N' ? 'btn-danger-00' : 'btn-outline-secondary'
                      ]"
                    @click="scrollToQuestion(idx)"
                  >
                    {{ idx + 1 }}
                  </button>
                </div>
              </div>
            </div>
            <div class="card-footer p-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <span class="badge bg-success me-2">✓</span>
                  <span class="small">Benar: {{ safeTotalCorrect }}</span>
                </div>
                <div>
                  <span class="badge bg-danger me-2">✗</span>
                  <span class="small">Salah: {{ totalQuestions - safeTotalCorrect }}</span>
                </div>
              </div>
              <div class="progress mb-2" style="height: 8px;">
                <div 
                  class="progress-bar bg-success" 
                  role="progressbar" 
                  :style="{ width: (safeTotalCorrect / totalQuestions * 100) + '%' }"
                ></div>
              </div>
              <p class="text-center small text-muted mb-0">
                {{ Math.round(safeTotalCorrect / totalQuestions * 100) }}% Benar
              </p>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script setup>
import { toRefs, computed, ref } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

const rawProps = defineProps({
  exam: { type: Object, required: false },
  grade: { type: Object, required: false },
  questions: { type: Array, required: false, default: () => [] }
});
const { exam, grade, questions } = toRefs(rawProps);

const activeQuestion = ref(0);

const totalQuestions = computed(() => (Array.isArray(questions.value) ? questions.value.length : 0));
const safeTotalCorrect = computed(() => Number(grade.value?.total_correct ?? 0));
const safeFinalGrade = computed(() => Number(grade.value?.final_grade ?? 0));
const gradeDisplay = computed(() => safeFinalGrade.value.toFixed(2));
const isReady = computed(() => !!grade.value && Array.isArray(questions.value));

const scrollToQuestion = (idx) => {
  activeQuestion.value = idx;
  const element = document.querySelectorAll('.card.mb-4')[idx];
  if (element) {
    element.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
};

const getGradeColorClass = (grade) => {
  if (grade >= 80) return 'bg-success text-white';
  if (grade >= 60) return 'bg-warning text-dark';
  return 'bg-danger text-white';
};

const getOptions = (q) => {
  const letters = ['A', 'B', 'C', 'D', 'E'];
  const out = [];
  for (let i = 1; i <= 5; i++) {
    const t = q?.[`option_${i}`];
    if (t !== undefined && t !== null && String(t).trim() !== '') {
      out.push({ number: i, letter: letters[i - 1], text: t });
    }
  }
  return out;
};

const asInt = (v) => {
  const n = parseInt(v, 10);
  return Number.isFinite(n) ? n : null;
};

const getOptionClass = (q, optionNumber) => {
  const classes = [];
  const correct = asInt(q?.question_answer);
  const chosen  = asInt(q?.user_answer);

  if (correct === optionNumber) {
    classes.push('border-success, bg-success-00');
  }
  if (chosen === optionNumber && q?.is_correct === 'N') {
    classes.push('border-danger, bg-danger-00');
  }
  if (classes.length === 0) {
    classes.push('border-light');
  }
  return classes.join(' ');
};

const getUserAnswerText = (q) => {
  const chosen = asInt(q?.user_answer);
  if (!chosen) return null;
  const letters = ['A', 'B', 'C', 'D', 'E'];
  return letters[chosen - 1] ?? null;
};

const getCorrectAnswerText = (q) => {
  const correct = asInt(q?.question_answer) ?? 1;
  const letters = ['A', 'B', 'C', 'D', 'E'];
  return letters[correct - 1] ?? 'A';
};
</script>

<style scoped>
.bg-success-00 {
  background-color:rgba(6, 255, 71, 0.3);
}
.bg-danger-00 {
  background-color:rgba(255, 99, 71, 0.3);
}
.btn-success-00 {
  background-color:rgba(6, 255, 71, 0.5);
}
.btn-danger-00 {
  background-color:rgba(255, 0, 0, 0.6);
}
.question-content {
  line-height: 1.7;
  color: #374151;
}
.question-content :deep(p) {
  margin-bottom: 1rem;
}
.question-content :deep(img) {
  max-width: 100%;
  height: auto;
  margin: 0.75rem 0;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
.question-content :deep(table) {
  width: 100%;
  border-collapse: collapse;
  margin: 0.75rem 0;
}
.question-content :deep(th),
.question-content :deep(td) {
  border: 1px solid #e5e7eb;
  padding: 0.5rem;
  text-align: left;
}
.question-content :deep(th) {
  background-color: #f9fafb;
}

.sticky-top {
  position: sticky;
}

.nav-link {
  background: none;
  border: none;
  padding: 0;
  color: inherit;
  cursor: pointer;
}
.btn-active {
  box-shadow: 0 0 0 3px rgba(13,110,253,.5);
}
</style>