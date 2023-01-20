import { getCurrentUser } from "@/api/auth";

export function useGetCurrentUser() {
  return new Promise((resolve, reject) => {
    if (JSON.parse(sessionStorage.getItem("cw-app-token")) == null) {
      return reject(null);
    }

    getCurrentUser()
      .then((res) => {
        const currentUser = res.data.items;
        currentUser.isAdmin = currentUser.roles.includes("ROLE_ADMIN");
        resolve(currentUser);
      })
      .catch((error) => {
        console.log(error);
        reject(null);
      });
  });
}
