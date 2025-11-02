<template>
  <div 
    :class="[
      'border rounded p-4 transition-all duration-200',
      task.completed 
        ? 'bg-green-50 border-green-200 opacity-80' 
        : 'bg-gray-50 hover:bg-gray-100'
    ]"
  >
    <div class="flex items-start gap-4">
      <!-- Checkbox -->
      <div class="flex-shrink-0 mt-1">
        <input
          type="checkbox"
          :checked="task.completed"
          @change="$emit('toggle-completion', task)"
          :disabled="task.loading"
          class="w-5 h-5 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2 disabled:opacity-50"
        />
      </div>

      <!-- Conteúdo da tarefa -->
      <div class="flex-1">
        <h3 :class="titleClasses">
          {{ task.title }}
        </h3>
        <p :class="descriptionClasses">
          {{ task.description }}
        </p>
      </div>

      <!-- Botões de ação -->
      <div class="shrink-0 flex gap-2">
        <!-- Ícone de editar -->
        <button
          @click="$emit('edit', task)"
          :disabled="task.loading"
          class="p-2 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-full transition-colors disabled:opacity-50"
          title="Editar tarefa"
        >
          <svg 
            v-if="!task.loading" 
            class="w-5 h-5" 
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
          >
            <path 
              stroke-linecap="round" 
              stroke-linejoin="round" 
              stroke-width="2" 
              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
            />
          </svg>
          <div v-else class="w-5 h-5 flex items-center justify-center">
            <div class="w-3 h-3 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
          </div>
        </button>

        <!-- Ícone de lixeira -->
        <button
          @click="$emit('delete', task)"
          :disabled="task.loading"
          class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-full transition-colors disabled:opacity-50"
          title="Excluir tarefa"
        >
          <svg 
            v-if="!task.loading" 
            class="w-5 h-5" 
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
          >
            <path 
              stroke-linecap="round" 
              stroke-linejoin="round" 
              stroke-width="2" 
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
            />
          </svg>
          <div v-else class="w-5 h-5 flex items-center justify-center">
            <div class="w-3 h-3 border-2 border-red-500 border-t-transparent rounded-full animate-spin"></div>
          </div>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { computed } from 'vue';

export default {
  name: 'TaskItem',
  props: {
    task: {
      type: Object,
      required: true
    }
  },
  emits: ['toggle-completion', 'edit', 'delete'],
  setup(props) {
    const titleClasses = computed(() => [
      'font-semibold text-lg',
      props.task.completed ? 'line-through text-gray-500' : ''
    ]);

    const descriptionClasses = computed(() => [
      'mt-2',
      props.task.completed ? 'line-through text-gray-400' : 'text-gray-600'
    ]);

    return {
      titleClasses,
      descriptionClasses,
    };
  }
};
</script>