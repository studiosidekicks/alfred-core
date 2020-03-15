import axios from 'axios';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Create axios instance
const service = axios.create({
  baseURL: process.env.ALFRED_API_BASE_URL,
  timeout: 10000, // Request timeout
});

// Request intercepter
service.interceptors.request.use(
  config => config,
  error => {
    Promise.reject(error);
  }
);

// response pre-processing
service.interceptors.response.use(
  response => {
    return response.data;
  },
  error => {
    let message = error.message;

    if (error.response.data && error.response.data.errors) {
      message = error.response.data.errors;
    } else if (error.response.data && error.response.data.message) {
      message = error.response.data.message;
    }

    return Promise.reject(message);
  },
);

export default service;
