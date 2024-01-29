import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Office/**/*.php',
        './resources/views/filament/office/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/jaocero/activity-timeline/resources/views/**/*.blade.php',

    ],
}
