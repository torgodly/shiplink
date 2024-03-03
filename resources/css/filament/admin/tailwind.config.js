import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/jaocero/activity-timeline/resources/views/**/*.blade.php',
        'resources/views/forms/components/rating.blade.php',
        'resources/views/tables/columns/rating-column.blade.php',
        "resources/views/forms/components/view-price.blade.php"
    ],
}
