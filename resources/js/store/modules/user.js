import { login, forgotPassword, logout, getInfo } from '@/api/auth';
import { getIsUserLoggedIn, setIsUserLoggedIn } from '@/utils/auth';
import router, { resetRouter } from '@/router';
import store from '@/store';

const state = {
  isUserLoggedIn: getIsUserLoggedIn(),
  userInfo: null,
  isUserSuperAdmin: false,
  permissions: [],
};

const mutations = {
  SET_IS_USER_LOGGED_IN: (state, status) => {
    state.isUserLoggedIn = status;
  },
  SET_USER_INFO: (state, userInfo) => {
    state.userInfo = userInfo;
  },
  SET_IS_SUPER_ADMIN: (state, status) => {
    state.isUserSuperAdmin = status;
  },
  SET_PERMISSIONS: (state, permissions) => {
    state.permissions = permissions;
  },
};

const actions = {
  // user login
  login({ commit }, userInfo) {
    const { email, password } = userInfo;
    return new Promise((resolve, reject) => {
      login({ email: email.trim(), password: password })
        .then(response => {
          commit('SET_IS_USER_LOGGED_IN', true);
          setIsUserLoggedIn(true);
          resolve('Logged in');
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // forgotten password reminder
  forgotPassword({ commit }, userInfo) {
    const { email } = userInfo;
    return new Promise((resolve, reject) => {
      forgotPassword({ email: email.trim() })
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // get user info
  getInfo({ commit, state }) {
    return new Promise((resolve, reject) => {
      getInfo()
        .then(response => {
          const { data } = response;

          if (!data) {
            reject('Verification failed, please log in again.');
          }

          const isUserSuperAdmin = data.is_super_admin;
          const permissions = data.permissions;

          commit('SET_USER_INFO', data);
          commit('SET_PERMISSIONS', permissions);
          commit('SET_IS_SUPER_ADMIN', isUserSuperAdmin);

          resolve(data);
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // user logout
  logout({ commit, state }) {
    return new Promise((resolve, reject) => {
      logout()
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          resolve();
        })
        .finally(() => {
          commit('SET_IS_USER_LOGGED_IN', false);
          commit('SET_PERMISSIONS', []);
          commit('SET_IS_SUPER_ADMIN', false);
          
          setIsUserLoggedIn(false);
          resetRouter();
        });
    });
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
