/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        colors: {
            'white-1': '#ffffff',
            'white-2': '#CED1D6B2',
            'black-1': '#242421',
            'black-2': '#000814',
            'blue-1': '#3F8CFF',
            'blue-2': '#3f70ff',
            'gray-1': '#828EA5',
            'gray-2': '#4a4f58',
            'gray-3': '#2c2f34',
            'red-1': '#CA3337',
            'ld-white': '#ffffff',
            'ld-gray': '#828EA5',
            'ld-navbar': '#f0f1f5',
            'ld-red': '#CA3337',
            'ld-yellow': '#F6B800',
            'ld-green': '#004029',
        },
        extend: {},
    },
    plugins: [
        require('flowbite/plugin')
    ],
}
