<script>
    import '../app.css';
</script>


<main>
    <slot />
</main>

<svelte:head>
  <meta name="viewport" content="width=device-width"> <!-- Add the viewport meta tag here -->
  <!-- Any other meta tags or head elements can be added here -->
</svelte:head>

<style>
    :root {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-weight: 500;
    }
    main {
        padding: 0;
        background-color: #f0f0f0;
    }
</style>
