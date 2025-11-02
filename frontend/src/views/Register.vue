<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-sm">
      <h1 class="text-2xl font-bold mb-6 text-center">Registrar</h1>
      <form @submit.prevent="handleRegister" class="flex flex-col gap-4">
        <input
          v-model="name"
          type="text"
          placeholder="Nome"
          class="border p-2 rounded"
          required
        />
        <input
          v-model="email"
          type="email"
          placeholder="Email"
          class="border p-2 rounded"
          required
        />
        <input
          v-model="password"
          type="password"
          placeholder="Senha"
          class="border p-2 rounded"
          required
        />
        <input
          v-model="password_confirmation"
          type="password"
          placeholder="Confirme a senha"
          class="border p-2 rounded"
          required
        />
        <button
          type="submit"
          class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 rounded"
        >
          Registrar
        </button>
      </form>
      <p class="mt-4 text-sm text-center">
        Já tem conta?
        <router-link to="/login" class="text-blue-500">Login</router-link>
      </p>
      <p v-if="errorMessage" class="text-red-500 mt-2 text-center">{{ errorMessage }}</p>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import { register } from "../api/tasks";
import { useRouter } from "vue-router";

export default {
  setup() {
    const name = ref("");
    const email = ref("");
    const password = ref("");
    const password_confirmation = ref("");
    const errorMessage = ref("");
    const router = useRouter();

    const handleRegister = async () => {
      if (password.value !== password_confirmation.value) {
        errorMessage.value = "Senhas não conferem";
        return;
      }
      try {
        await register({
          name: name.value,
          email: email.value,
          password: password.value,
          password_confirmation: password_confirmation.value,
        });
        router.push("/login");
      } catch (error) {
        // se existir campo "message" na resposta do erro, exibir essa mensagem
        if (error.response && error.response.data && error.response.data.message) {
          errorMessage.value = error.response.data.message;
          return;
        }
        errorMessage.value = "Erro ao registrar usuário";
        console.error(error);
      }
    };

    return { name, email, password, password_confirmation, errorMessage, handleRegister };
  },
};
</script>
