<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-sm">
      <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>
      <form @submit.prevent="handleLogin" class="flex flex-col gap-4">
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
        <button
          type="submit"
          class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded"
        >
          Entrar
        </button>
      </form>
      <p class="mt-4 text-sm text-center">
        Não tem conta?
        <router-link to="/register" class="text-blue-500">Registre-se</router-link>
      </p>
      <p v-if="errorMessage" class="text-red-500 mt-2 text-center">{{ errorMessage }}</p>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import { login } from "../api/tasks";
import { useRouter } from "vue-router";

export default {
  setup() {
    const email = ref("");
    const password = ref("");
    const errorMessage = ref("");
    const router = useRouter();

    const handleLogin = async () => {
      try {
        const res = await login({ email: email.value, password: password.value });
        const token = res.data.token; // ajuste conforme sua API Laravel
        localStorage.setItem("token", token); // salva o token
        router.push("/home"); // redireciona para Home
      } catch (error) {
        errorMessage.value = "Email ou senha incorretos";
        console.error(error);
      }
    };

    return { email, password, errorMessage, handleLogin };
  },
};
</script>
