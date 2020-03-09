export function getIsUserLoggedIn() {
  return localStorage.isUserLoggedIn ? JSON.parse(localStorage.isUserLoggedIn) : false;
}

export function setIsUserLoggedIn(status) {
  return localStorage.isUserLoggedIn = status;
}