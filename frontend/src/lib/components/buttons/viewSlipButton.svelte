<script lang="ts">
    import {createEventDispatcher} from 'svelte';
    export let purchase: any;
    
    const dispatch = createEventDispatcher();

    function handleClick() {
        dispatch('viewSlip', {
            slip: purchase.slip,
            id: "ID : " + purchase.purchase_id,
            price: "Rs. " + purchase.price
        });
    }
</script>

{#if purchase.slip}
    <button on:click={handleClick}
        title="Click to view the Slip"
        class="w-20 h-8 text-sm flex text-center p-2 bg-indigo-300 rounded-lg text-white justify-center items-center hover:bg-indigo-400"
        >
        View Slip
    </button>
{/if}