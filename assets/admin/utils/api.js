import axios from 'axios'
import { useAuthStore } from '@/stores/auth' // Mettez le chemin correct selon votre configuration

const api = axios.create()

// Intercepteur pour ajouter le token d'authentification aux requêtes sortantes
api.interceptors.request.use(config => {
  const authStore = useAuthStore()
  if (authStore.token) {
    config.headers.Authorization = `Bearer ${authStore.token}`
  }
  return config;
}, error => {
  return Promise.reject(error)
})

export default api