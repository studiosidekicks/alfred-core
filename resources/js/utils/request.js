import axios from 'axios';

// Create axios instance
const service = axios.create({
  baseURL: process.env.ALFRED_API_BASE_URL,
  timeout: 10000, // Request timeout
});

// Request intercepter
service.interceptors.request.use(
  config => config,
  error => {
    console.log('helloooo ERROR', error);
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

    console.log('hello ERROR2', message);
    return Promise.reject(message);
  },
);

export default service;
