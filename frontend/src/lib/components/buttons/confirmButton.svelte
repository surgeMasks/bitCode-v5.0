<script lang="ts">
    import { scale } from 'svelte/transition';
    import { Spinner } from 'flowbite-svelte';
    import Overlay from '$lib/components/ui/overlay.svelte';
    // import { CloseCircleSolid } from 'flowbite-svelte';

    export let onConfirm: () => Promise<void>;
    export let onCancel: () => void;
    export let msg: string = "Are you sure?";
    export let isVibePositive = false
    let isResponseLoading = false;
    
    async function submitForm() {
        isResponseLoading = true;
        await onConfirm();
        isResponseLoading = false;
    }

    let yesColour = isVibePositive ? 'blue' : 'red';
    let noColour = isVibePositive ? 'red' : 'blue';
</script>
<Overlay>
    <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2  bg-white p-8 rounded-lg shadow-lg z-50" transition:scale={{duration: 300, start: 0.1}}>
        <button class="border-none cursor-pointer bg-transparent p-1 absolute top-1 right-1 hover:bg-transparent"
            on:click={onCancel}>
            <iconify-icon icon="carbon:close-filled"></iconify-icon>
        </button>
        <h3 class="text-xl text-black my-10 text-center font-bold py-2">{msg}</h3>
        <div class="flex justify-between gap-x-4">
            <button class="w-28 h-10 border-none text-white text-sm cursor-pointer rounded-lg bg-{yesColour}-500 hover:bg-{yesColour}-700 duration-300 hover:scale-105" 
            on:click={submitForm} disabled={isResponseLoading}>
            {#if isResponseLoading}
                <Spinner class="text-center" size="6" color="white" />
            {:else}
                Yes
            {/if}
            </button>
            <button class="w-28 h-10 border-none text-white text-sm cursor-pointer rounded-lg bg-{noColour}-500 hover:bg-{noColour}-700  duration-300  hover:scale-105" 
            on:click={onCancel}>
                No
            </button>
        </div>
    </div>
</Overlay>

