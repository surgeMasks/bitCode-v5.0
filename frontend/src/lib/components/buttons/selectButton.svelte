<script lang="ts">
    export let activeColour = 'blue'
    export let inactiveColour = 'gray'
    export let width = '32'
    export let isActive = false
    export let fn = () => {}

    $: buttonClass = isActive ? `bg-${activeColour}-700` : `bg-${inactiveColour}-700 hover:bg-${inactiveColour}-600`;
</script>

    <button 
        on:click={fn} 
        disabled={isActive}
        class="px-4 my-2 py-2 h-10 w-{width} mr-4 text-white rounded {buttonClass} hover:indigo h-auto">
        <slot></slot>
    </button>