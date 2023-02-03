import { openDB } from "idb";

const CART_STORE_NAME = "Cart";

export function initDB() {
  return openDB("BBB shop", 1, {
    upgrade(db) {
      const storeCart = db.createObjectStore(CART_STORE_NAME, {
        keyPath: "id",
      });

      storeCart.createIndex("id", "id");
      storeCart.put({
        id: "cart",
        products: [],
        total: 0,
      });
    },
  });
}

export function getCart() {
  return initDB().then((db) => {
    return db.getFromIndex(CART_STORE_NAME, "id", "cart");
  });
}

export function updateCart(cart = {}) {
  return initDB().then((db) => {
    const tx = db.transaction(CART_STORE_NAME, "readwrite");
    tx.store.put(cart);
    return tx.done;
  });
}

export function clearCart() {
  return initDB().then(async (db) => {
    const cart = await db.getFromIndex(CART_STORE_NAME, "id", "cart");
    cart.products = [];
    cart.total = 0;
    const tx = db.transaction(CART_STORE_NAME, "readwrite");
    tx.store.put(cart);
    return tx.done;
  });
}
