import { api } from "./index";
const actionScope = `Loader`;
export function setupInterceptors({ dispatch }) {
  let requestsPending = 0;
const req = {
    pending: () => {
      requestsPending++;
      dispatch(`${actionScope}/show`);
    },
    done: () => {
      requestsPending--;
if (requestsPending <= 0) {
        dispatch(`${actionScope}/hide`);
      }
    }
  };
api.interceptors.request.use(
    config => {
      req.pending();
return config;
    },
    error => {
      requestsPending--;
req.done();
return Promise.reject(error);
    }
  );
api.interceptors.response.use(
    ({ data }) => {
      req.done();
return Promise.resolve(data);
    },
    error => {
      req.done();
return Promise.reject(error);
    }
  );
}