//import jwtDecode from 'jwt-decode';

interface JwtPayload {
  exp?: number;
  iat?: number;
  roles: string[];
  username: string;
}

const API_AUTH_PATH = "/auth";

const getAccessToken = () => localStorage.getItem("token");

const authProvider = {
  login: async ({username, password}: { username: string; password: string }) => {
    const request = new Request(API_AUTH_PATH, {
      method: "POST",
      body: JSON.stringify({ email: username, password }),
      headers: new Headers({ "Content-Type": "application/json" }),
    });

    const response = await fetch(request);

    if (response.status < 200 || response.status >= 300) {
      throw new Error(response.statusText);
    }

    const auth = await response.json();
    localStorage.setItem("token", auth.token);
  },
  logout: () => {
    localStorage.removeItem("token");
    return Promise.resolve();
  },
  checkAuth: () => getAccessToken() ? Promise.resolve() : Promise.reject(),
  checkError: (error: { status: number }) => {
    const status = error.status;
    if (status === 401 || status === 403) {
      localStorage.removeItem("token");
      return Promise.reject();
    }

    return Promise.resolve();
  },
  getIdentity: () => {
    const token = getAccessToken();

    if (!token) return Promise.reject();

    //const decoded = jwtDecode<JwtPayload>(token);
    //console.log(decoded);

    return Promise.resolve({
      id: "",
      fullName: "dk", //decoded.username,
      avatar: "",
    });
  },
  getPermissions: () => Promise.resolve(""),
};

export default authProvider;
