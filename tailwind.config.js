/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './index.html',
    './src/**/*.{js,ts,jsx,tsx}',
    './client/src/**/*.{js,ts,jsx,tsx}',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#3b82f6',
        'primary-dark': '#2563eb',
        'primary-light': '#60a5fa',
        'dark-navy': '#1e293b',
        'soft-white': '#f8fafc',
        'gray-text': '#64748b',
        'border-light': '#e2e8f0',
        'light-blue': '#f0f9ff',
        'section-bg': '#ffffff',
        'card-bg': '#ffffff',
      },
      fontFamily: {
        sans: ['Inter', 'Poppins', 'sans-serif'],
      },
      boxShadow: {
        soft: '0 4px 6px -1px rgba(0, 0, 0, 0.08), 0 2px 4px -1px rgba(0, 0, 0, 0.04)',
        premium: '0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
        card: '0 2px 8px rgba(0, 0, 0, 0.06)',
      },
      borderRadius: {
        sm: '0.375rem',
        DEFAULT: '0.5rem',
        lg: '0.75rem',
        xl: '1rem',
        '2xl': '1.25rem',
      },
      maxWidth: {
        'container': '1280px',
      },
      spacing: {
        '18': '4.5rem',
        '22': '5.5rem',
        '26': '6.5rem',
      },
    },
  },
  plugins: [],
}