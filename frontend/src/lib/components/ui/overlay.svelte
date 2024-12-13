<script>
    import { fade } from 'svelte/transition';
</script>

<div class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-40 z-40" 
    transition:fade={{duration: 300}}>
    <slot></slot>
</div>