<script lang="ts">
    import { Spinner } from 'flowbite-svelte';

    export let nextPage: string | undefined;
    export let loadMore: () => void;
    export let endMessage: string = "No More";
    let isLoadingMore = false;

    async function onLoadMore() {
        try{
            isLoadingMore = true;
            await loadMore();
        } catch (error) {
            console.error('Failed to fetch more data', error);
        } finally {
            isLoadingMore = false;
        }
    }
</script>

{#if nextPage}
    <div class="flex justify-center mt-8">
        <button 
            class="bg-blue-500 text-white h-10 w-28 py-2 px-4 text-center rounded hover:bg-blue-600 transition-colors duration-150"
            on:click={onLoadMore} 
            disabled={isLoadingMore}
        >
            {#if isLoadingMore}
                <Spinner class="text-center" size="6" color="white" />
            {:else}
                Load More
            {/if}
        </button>
    </div>
    {:else}
    <div class="flex text-xl justify-center py-4 text-gray-400 px-4 rounded">
        {endMessage}
    </div>
{/if}