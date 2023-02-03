import { getCurrentUser } from "@/api/auth";

export function useGetCurrentUser() {
  return new Promise((resolve, reject) => {
    if (JSON.parse(sessionStorage.getItem("cw-app-token")) == null) {
      return reject(null);
    }

    getCurrentUser()
      .then(({ data }) => {
        const currentUser = { ...data };
        currentUser.isAdmin = currentUser.roles.includes("ROLE_ADMIN");
        currentUser.isDeliverer = currentUser.roles.includes("ROLE_DELIVERER");
        currentUser.isClient = currentUser.roles.includes("ROLE_CLIENT");
        resolve(currentUser);
      })
      .catch((error) => {
        console.log(error);
        reject(null);
      });
  });
}
