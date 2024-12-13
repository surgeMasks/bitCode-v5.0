<script lang="ts">
    export let id:  string = "0";
    export let onClick: (id: string) => void; 
    export let status: number = 1;
</script>

<div class="s s--slider absolute top-4 left-4 hover:scale-110">
        <button 
            role="switch"
            aria-checked={status != 0}
            aria-labelledby={`switch-${id}`}
            title={status !== 0 ? 'Deactivate' : 'Activate'}
            on:click={() => onClick(id)}>
        </button>
    </div>


<style>
    :root { 
        --accent-color: #3b86f7;
        --gray: #ccc;
    }
    .s--slider {
        display: flex;
        align-items: center;
    }
    .s--slider button {
        width: 3em;
        height: 1.6em;
        position: relative;
        margin: 0 0 0 0.5em;
        background: var(--gray);
        border: none;
    }
    .s--slider button::before {
        content: '';
        position: absolute;
        width: 1.3em;
        height: 1.3em;
        background: #fff;
        top: 0.13em;
        right: 1.5em;
        transition: transform 0.3s;
    }
    .s--slider button[aria-checked='true'] {
        background-color: var(--accent-color);
    }
    .s--slider button[aria-checked='true']::before {
        transform: translateX(1.3em);
        transition: transform 0.3s;
    }
    .s--slider button:focus {
        box-shadow: 0 0px 0px 1px var(--accent-color);
    }
    .s--slider button {
        border-radius: 1.5em;
    } 
    .s--slider button::before {
        border-radius: 100%;
    }
    .s--slider button:focus {
        box-shadow: 0 0px 8px var(--accent-color);
        border-radius: 1.5em;
    }
</style>