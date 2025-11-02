module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: "#ffe4f0",
          100: "#ffcce0",
          200: "#ff99c1",
          300: "#ff66a3",
          400: "#ff339f",
          500: "#ff0080",
          600: "#e60073",
          700: "#bf0060",
          800: "#99004d",
          900: "#73003a",
        },
        success: "#22c55e",
        error: "#ef4444",
      },
    },
  },
  plugins: [],
}
