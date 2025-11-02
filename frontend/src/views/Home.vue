<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Header com logout -->
    <div class="bg-white shadow-md p-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold">TaskManager</h1>
      <button 
        @click="handleLogout"
        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
      >
        Sair
      </button>
    </div>

    <!-- Conteúdo principal -->
    <div class="container mx-auto p-4">
      <div class="bg-white rounded shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-bold">Minhas Tarefas</h2>
          <button 
            @click="toggleCreateForm"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
          >
            {{ showCreateForm ? 'Cancelar' : 'Nova Tarefa' }}
          </button>
        </div>

        <!-- Formulário de criar/editar tarefa -->
        <TaskForm
          v-if="showCreateForm || editingTask"
          :task="editingTask"
          :loading="isCreating || isEditing"
          @submit="handleFormSubmit"
          @cancel="cancelForm"
        />
        
        <!-- Loading -->
        <div v-if="loading" class="text-center py-4">
          <p>Carregando tarefas...</p>
        </div>

        <!-- Erro -->
        <div v-else-if="errorMessage" class="text-red-500 text-center py-4">
          {{ errorMessage }}
          <button 
            @click="fetchTasks" 
            class="ml-2 text-blue-500 underline"
          >
            Tentar novamente
          </button>
        </div>

        <!-- Lista de tarefas -->
        <div v-else-if="filteredTasks.length > 0" class="space-y-3">
          <TaskItem
            v-for="task in filteredTasks"
            :key="task.id"
            :task="task"
            @toggle-completion="toggleTaskCompletion"
            @edit="startEditTask"
            @delete="deleteTaskConfirm"
          />
        </div>

        <!-- Sem tarefas -->
        <div v-else class="text-center py-8">
          <p class="text-gray-500 mb-4">{{ emptyMessage }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { getTasks, createTask, updateTask, deleteTask } from '../api/tasks';
import TaskForm from '../components/TaskForm.vue';
import TaskItem from '../components/TaskItem.vue';

export default {
  name: "Home",
  components: {
    TaskForm,
    TaskItem
  },
  setup() {
    const tasks = ref([]);
    const loading = ref(false);
    const errorMessage = ref("");
    const showCreateForm = ref(false);
    const isCreating = ref(false);
    const isEditing = ref(false);
    const editingTask = ref(null);
    const router = useRouter();

    // Computed properties
    const filteredTasks = computed(() => {
      return tasks.value.filter(task => task !== null);
    });

    const emptyMessage = computed(() => {
      return loading.value ? 'Carregando...' : 'Nenhuma tarefa encontrada.';
    });

    // Methods
    const toggleCreateForm = () => {
      showCreateForm.value = !showCreateForm.value;
      if (editingTask.value) {
        editingTask.value = null;
      }
    };

    const fetchTasks = async () => {
      loading.value = true;
      errorMessage.value = "";
      
      try {
        const token = localStorage.getItem('token');
        
        if (!token) {
          router.push('/login');
          return;
        }

        const response = await getTasks();
        tasks.value = Array.isArray(response.data) ? response.data : response.data.data || [];
        
      } catch (error) {
        console.error('Erro ao buscar tarefas:', error);
        
        if (error.response?.status === 401) {
          localStorage.removeItem('token');
          router.push('/login');
          return;
        }
        
        errorMessage.value = 'Erro ao carregar tarefas. Verifique sua conexão.';
      } finally {
        loading.value = false;
      }
    };

    const handleFormSubmit = async (formData) => {
      if (editingTask.value) {
        await handleEditTask(formData);
      } else {
        await handleCreateTask(formData);
      }
    };

    const handleCreateTask = async (formData) => {
      isCreating.value = true;
      
      try {
        await createTask(formData);
        showCreateForm.value = false;
        await fetchTasks();
        
      } catch (error) {
        console.error('Erro ao criar tarefa:', error);
        errorMessage.value = 'Erro ao criar tarefa. Tente novamente.';
      } finally {
        isCreating.value = false;
      }
    };

    const startEditTask = (task) => {
      editingTask.value = task;
      showCreateForm.value = false;
    };

    const handleEditTask = async (formData) => {
      isEditing.value = true;
      
      try {
        await updateTask(editingTask.value.id, {
          title: formData.title,
          description: formData.description,
          completed: editingTask.value.completed
        });
        
        editingTask.value = null;
        await fetchTasks();
        
      } catch (error) {
        console.error('Erro ao editar tarefa:', error);
        errorMessage.value = 'Erro ao editar tarefa. Tente novamente.';
      } finally {
        isEditing.value = false;
      }
    };

    const cancelForm = () => {
      editingTask.value = null;
      showCreateForm.value = false;
    };

    const toggleTaskCompletion = async (task) => {
      task.loading = true;
      
      try {
        const newCompleted = !task.completed;
        await updateTask(task.id, {
          title: task.title,
          description: task.description,
          completed: newCompleted
        });
        await fetchTasks();
        
      } catch (error) {
        console.error('Erro ao atualizar tarefa:', error);
        errorMessage.value = 'Erro ao atualizar tarefa.';
      } finally {
        task.loading = false;
      }
    };

    const deleteTaskConfirm = async (task) => {
      if (!confirm(`Tem certeza que deseja excluir a tarefa "${task.title}"?`)) return;
      
      task.loading = true;
      
      try {
        await deleteTask(task.id);
        await fetchTasks();
        
      } catch (error) {
        console.error('Erro ao excluir tarefa:', error);
        errorMessage.value = 'Erro ao excluir tarefa.';
      } finally {
        task.loading = false;
      }
    };

    const handleLogout = () => {
      localStorage.removeItem('token');
      router.push('/login');
    };

    onMounted(() => {
      fetchTasks();
    });

    return {
      tasks,
      loading,
      errorMessage,
      showCreateForm,
      isCreating,
      isEditing,
      editingTask,
      filteredTasks,
      emptyMessage,
      toggleCreateForm,
      handleFormSubmit,
      startEditTask,
      cancelForm,
      toggleTaskCompletion,
      deleteTaskConfirm,
      handleLogout,
      fetchTasks
    };
  }
};
</script>