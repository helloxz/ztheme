/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './**/*.php',
    './static/js/*.js',
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#eff6ff',
          100: '#dbeafe',
          200: '#bfdbfe',
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
          800: '#1e40af',
          900: '#1e3a8a',
        },
      },
      fontFamily: {
        sans: [
          '-apple-system',
          'BlinkMacSystemFont',
          '"Segoe UI"',
          'Roboto',
          '"Helvetica Neue"',
          'Arial',
          '"Noto Sans SC"',
          'sans-serif',
        ],
        mono: [
          'Monaco',
          'Consolas',
          '"Andale Mono"',
          '"DejaVu Sans Mono"',
          'monospace',
        ],
      },
      borderRadius: {
        'xl': '0.75rem',
        '2xl': '1rem',
      },
      boxShadow: {
        'card': '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
        'card-hover': '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
      },
      typography: {
        DEFAULT: {
          css: {
            maxWidth: 'none',
            'h1, h2, h3, h4, h5, h6': {
              fontWeight: '600',
            },
            p: {
              marginTop: '1.25em',
              marginBottom: '1.25em',
            },
            'ul, ol': {
              paddingLeft: '1.625em',
            },
            ul: {
              listStyleType: 'disc',
            },
            ol: {
              listStyleType: 'decimal',
            },
            'li::marker': {
              color: '#94a3b8',
            },
            'li + li': {
              marginTop: '0.5em',
            },
            blockquote: {
              borderLeftWidth: '4px',
              borderLeftColor: '#3b82f6',
              backgroundColor: '#f8fafc',
              paddingLeft: '1.25em',
              paddingRight: '1.25em',
              paddingTop: '1em',
              paddingBottom: '1em',
              fontStyle: 'italic',
              borderRadius: '0 0.75rem 0.75rem 0',
              marginTop: '1.5em',
              marginBottom: '1.5em',
            },
            'blockquote p:first-of-type': {
              marginTop: '0',
            },
            'blockquote p:last-of-type': {
              marginBottom: '0',
            },
            'blockquote p:first-of-type::before': {
              content: 'none',
            },
            'blockquote p:last-of-type::after': {
              content: 'none',
            },
            img: {
              borderRadius: '0.75rem',
              marginTop: '1.5em',
              marginBottom: '1.5em',
              boxShadow: '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)',
            },
            code: {
              fontWeight: '400',
            },
            'code:not(pre code)': {
              backgroundColor: '#f1f5f9',
              padding: '0.2em 0.4em',
              borderRadius: '0.375rem',
              fontSize: '0.875em',
            },
            'code::before': {
              content: 'none',
            },
            'code::after': {
              content: 'none',
            },
            table: {
              width: '100%',
              borderRadius: '0.75rem',
              overflow: 'hidden',
              borderCollapse: 'collapse',
              marginTop: '1.5em',
              marginBottom: '1.5em',
            },
            thead: {
              backgroundColor: '#f1f5f9',
            },
             'th, td': {
               padding: '0.75em 1em',
               borderWidth: '1px',
               borderColor: '#e2e8f0',
             },
             'th:first-child, td:first-child': {
               paddingLeft: '1em',
             },
             'tbody tr:nth-child(even)': {
               backgroundColor: '#f8fafc',
             },
            hr: {
              marginTop: '2em',
              marginBottom: '2em',
              borderColor: '#e2e8f0',
            },
            a: {
              color: '#3b82f6',
              textDecoration: 'underline',
              textDecorationColor: '#93c5fd',
              textUnderlineOffset: '2px',
              transition: 'color 0.2s, text-decoration-color 0.2s',
            },
            'a:hover': {
              color: '#2563eb',
              textDecorationColor: '#2563eb',
            },
          },
        },
        invert: {
          css: {
            blockquote: {
              backgroundColor: '#0f172a',
              borderLeftColor: '#60a5fa',
              borderColor: '#334155',
            },
            'li::marker': {
              color: '#64748b',
            },
            'code:not(pre code)': {
              backgroundColor: '#334155',
              color: '#e2e8f0',
            },
            thead: {
              backgroundColor: '#1e293b',
            },
            'th, td': {
              borderColor: '#334155',
            },
            'tbody tr:nth-child(even)': {
              backgroundColor: '#1e293b',
            },
            hr: {
              borderColor: '#334155',
            },
            a: {
              color: '#60a5fa',
              textDecorationColor: '#3b82f6',
            },
            'a:hover': {
              color: '#93c5fd',
              textDecorationColor: '#60a5fa',
            },
          },
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}
