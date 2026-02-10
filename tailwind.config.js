/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Livewire/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#fef2f2',
          100: '#fee2e2',
          200: '#fecaca',
          300: '#fca5a5',
          400: '#f87171',
          500: '#ef4444',
          600: '#dc2626',
          700: '#b91c1c',
          800: '#991b1b',
          900: '#7f1d1d',
        }
      }
    },
  },
  plugins: [require("daisyui")],
  daisyui: {
    themes: [
      {
        smartk3: {
          "primary": "#dc2626",
          "primary-content": "#ffffff",
          "secondary": "#f97316",
          "secondary-content": "#ffffff",
          "accent": "#fbbf24",
          "accent-content": "#1f2937",
          "neutral": "#374151",
          "neutral-content": "#f3f4f6",
          "base-100": "#ffffff",
          "base-200": "#f3f4f6",
          "base-300": "#e5e7eb",
          "base-content": "#1f2937",
          "info": "#3b82f6",
          "info-content": "#ffffff",
          "success": "#22c55e",
          "success-content": "#ffffff",
          "warning": "#f59e0b",
          "warning-content": "#1f2937",
          "error": "#ef4444",
          "error-content": "#ffffff",
        },
      },
      "light",
      "dark",
    ],
    darkTheme: "dark",
  },
}
