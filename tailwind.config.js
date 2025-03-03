/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        "nf-primary": "rgba(91,1,23,100)",
        "nf-second": "rgba(235,225,227,100)",
        "nf-third": "rgba(244,117,35,100)",
        "nf-fourth": "rgba(249,181,28,100)",
        "nf-fiveth": "rgba(204,157,47,100)",
        "nf-sixth": "rgba(36,48,84,100)",
      },
    },
  },
  plugins: [],
}

