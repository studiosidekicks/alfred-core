
const state = {
  sidebar: {
    opened: false,
    activeMenuItemPath: null,
  }
};

const mutations = {
  TOGGLE_SIDEBAR: state => {
    state.sidebar.opened = !state.sidebar.opened;
  },
  CLOSE_SIDEBAR: (state, withoutAnimation) => {
    state.sidebar.opened = false;
  },
  TOGGLE_DEVICE: (state, device) => {
    state.device = device;
  },
  SET_ACTIVE_MENU_ITEM_PATH: (state, path) => {
    state.sidebar.activeMenuItemPath = path;
  }
};

const actions = {
  toggleSideBar({ commit }) {
    commit('TOGGLE_SIDEBAR');
  },
  closeSideBar({ commit }, { withoutAnimation }) {
    commit('CLOSE_SIDEBAR', withoutAnimation);
  },
  toggleDevice({ commit }, device) {
    commit('TOGGLE_DEVICE', device);
  },
  setActiveMenuItemPath({ commit }, { path }) {
    commit('SET_ACTIVE_MENU_ITEM_PATH', path);
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
