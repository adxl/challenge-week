/* eslint-env node */

module.exports = {
  root: true,
  rules: {
    indent: ["error", 2],
    "prettier/prettier": ["error", { printWidth: 100, tabWidth: 2 }],
    "vue/multi-word-component-names": "off",
  },
  extends: ["plugin:vue/vue3-essential", "eslint:recommended", "@vue/eslint-config-prettier"],
  parserOptions: {
    ecmaVersion: "latest",
  },
};
