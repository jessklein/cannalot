# Sass Build Scripts

This project uses Sass for CSS preprocessing.

## Available Scripts

### Development
```bash
npm run dev
# or
npm run sass:dev
```
Watches for changes and recompiles Sass files with source maps.

### Production Build
```bash
npm run build
# or  
npm run sass:build
```
Compiles and compresses Sass files for production.

### Watch Mode
```bash
npm run sass
```
Basic watch mode without source maps.

## File Structure

```
assets/
├── scss/
│   ├── app.scss              # Main Sass file
│   ├── components/           # UI components
│   │   ├── _buttons.scss
│   │   ├── _forms.scss
│   │   ├── _cards.scss
│   │   ├── _tables.scss
│   │   ├── _badges.scss
│   │   ├── _modals.scss
│   │   └── _alerts.scss
│   ├── layouts/              # Layout components
│   │   ├── _sidebar.scss
│   │   ├── _header.scss
│   │   └── _main.scss
│   ├── pages/                # Page-specific styles
│   │   ├── _dashboard.scss
│   │   ├── _inbox.scss
│   │   ├── _tickets.scss
│   │   ├── _tasks.scss
│   │   ├── _clients.scss
│   │   ├── _services.scss
│   │   └── _billing.scss
│   └── utilities/            # Variables, mixins, functions
│       ├── _variables.scss
│       ├── _mixins.scss
│       ├── _functions.scss
│       ├── _reset.scss
│       ├── _typography.scss
│       ├── _helpers.scss
│       └── _animations.scss
└── css/
    ├── app.css               # Compiled CSS
    └── app.css.map           # Source map
```

## Features

- **Modern Sass structure** with organized partials
- **Custom variables** for colors, spacing, typography
- **Mixins and functions** for reusable styles
- **Component-based** architecture
- **Responsive design** mixins
- **Animation utilities**
- **Form components** with validation states
- **Button variants** and styles
- **Badge and status** indicators
- **Table styling**
- **Card components**
