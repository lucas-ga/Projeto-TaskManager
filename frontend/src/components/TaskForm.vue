<template>
  <div class="mb-6 p-4 border rounded bg-gray-50">
    <h3 class="font-semibold mb-3">
      {{ task ? 'Editar Tarefa' : 'Criar Nova Tarefa' }}
    </h3>
    <form @submit.prevent="handleSubmit" class="space-y-3">
      <input
        v-model="formData.title"
        type="text"
        placeholder="Título da tarefa"
        class="w-full border p-2 rounded"
        :class="{ 'border-red-500': !isValidTitle }"
        required
      />
      <p v-if="!isValidTitle && formData.title" class="text-red-500 text-sm">
        Título deve ter pelo menos 3 caracteres
      </p>
      
      <textarea
        v-model="formData.description"
        placeholder="Descrição da tarefa"
        class="w-full border p-2 rounded h-20"
        :class="{ 'border-red-500': !isValidDescription }"
        required
      ></textarea>
      <p v-if="!isValidDescription && formData.description" class="text-red-500 text-sm">
        Descrição deve ter pelo menos 10 caracteres
      </p>
      
      <div class="flex gap-2">
        <button
          type="submit"
          :disabled="loading || !isFormValid"
          class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded disabled:opacity-50"
        >
          {{ loading ? 'Salvando...' : (task ? 'Salvar Alterações' : 'Criar Tarefa') }}
        </button>
        <button
          type="button"
          @click="$emit('cancel')"
          class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
        >
          Cancelar
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import { ref, computed, watch } from 'vue';

export default {
  name: 'TaskForm',
  props: {
    task: {
      type: Object,
      default: null
    },
    loading: {
      type: Boolean,
      default: false
    }
  },
  emits: ['submit', 'cancel'],
  setup(props, { emit }) {
    const formData = ref({
      title: '',
      description: ''
    });

    // Computed properties para validação
    const isValidTitle = computed(() => {
      return formData.value.title.trim().length >= 3;
    });

    const isValidDescription = computed(() => {
      return formData.value.description.trim().length >= 10;
    });

    const isFormValid = computed(() => {
      return isValidTitle.value && isValidDescription.value;
    });

    // Watch para preencher formulário quando há task para editar
    watch(() => props.task, (newTask) => {
      if (newTask) {
        formData.value = {
          title: newTask.title,
          description: newTask.description
        };
      } else {
        formData.value = {
          title: '',
          description: ''
        };
      }
    }, { immediate: true });

    const handleSubmit = () => {
      if (isFormValid.value) {
        emit('submit', { ...formData.value });
      }
    };

    return {
      formData,
      isValidTitle,
      isValidDescription,
      isFormValid,
      handleSubmit
    };
  }
};
</script>