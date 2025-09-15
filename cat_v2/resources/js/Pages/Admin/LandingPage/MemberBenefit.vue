<template>
  <div class="page-wrapper">
    <div class="page-content">
      <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Landing Page</div>
        <div class="ps-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
              <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bx bx-home-alt"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Kelola Keuntungan Member</li>
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

      <div class="card border-top border-0 border-3 border-primary">
        <div class="card-body">
          <h4 class="mb-4">Kelola Keuntungan Member</h4>
          <form @submit.prevent="submitForm">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-start">Keuntungan Member</th>
                    <th
                      v-for="level in levels"
                      :key="level.id"
                      class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                    >
                      {{ level.name }}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="benefit in benefits" :key="benefit.id">
                    <td class="text-start">
                      <p class="text-xs font-weight-bold mb-0">{{ benefit.name }}</p>
                    </td>
                    <td
                      v-for="level in levels"
                      :key="level.id"
                      class="align-middle text-center"
                    >
                      <div class="form-check d-flex justify-content-center">
                        <input
                          type="checkbox"
                          class="form-check-input"
                          :id="`benefit-${benefit.id}-level-${level.id}`"
                          :checked="form.levels[level.id]?.includes(benefit.id)"
                          @change="toggleCheckbox(level.id, benefit.id)"
                        >
                        <label
                          class="form-check-label"
                          :for="`benefit-${benefit.id}-level-${level.id}`"
                        ></label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-end mt-4">
              <button
                type="submit"
                class="btn btn-primary px-4"
                :disabled="form.processing"
              >
                <i class='bx bx-save mr-1'></i>
                <span v-if="form.processing">Menyimpan...</span>
                <span v-else>Simpan Perubahan</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LayoutAdmin from '../../../Layouts/Layout.vue';
import { useForm } from '@inertiajs/inertia-vue3';

export default {
  layout: LayoutAdmin,
  props: {
    levels: Array,
    benefits: Array,
    flash: Object
  },
  setup(props) {
    const form = useForm({
      levels: {}
    });

    props.levels.forEach(level => {
      form.levels[level.id] = level.benefits?.map(b => b.id) || [];
    });

    return { form, levels: props.levels, benefits: props.benefits };
  },
  methods: {
    toggleCheckbox(levelId, benefitId) {
      if (!this.form.levels[levelId]) {
        this.form.levels[levelId] = [];
      }

      const index = this.form.levels[levelId].indexOf(benefitId);
      if (index > -1) {
        this.form.levels[levelId].splice(index, 1); 
      } else {
        this.form.levels[levelId].push(benefitId); 
      }
    },
    submitForm() {
  console.log("Data yang dikirim:", JSON.stringify(this.form.levels, null, 2));

  this.form.post('/admin/landing-page/member-benefits/update', {
    preserveScroll: true,
    onSuccess: () => {
      console.log('Berhasil disimpan!');
    },
    onError: (errors) => {
      console.error('Gagal menyimpan:', errors);
    }
  });
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
.table-responsive {
  overflow-x: auto;
}

.form-check-input {
  width: 1.2em;
  height: 1.2em;
  margin-top: 0.15em;
}

.card {
  border-radius: 10px;
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
