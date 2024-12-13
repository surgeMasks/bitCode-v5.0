<script>
  import { Button } from "flowbite-svelte";
  export let onClick = () => {};
  export let text = "Visit";
  export let disabled = false;
</script>

<Button
    on:click="{onClick}"
    disabled="{disabled}"
    class="text-sm py-2 px-3 w-28 h-10 text-white bg-indigo-500 hover:bg-indigo-600 rounded absolute bottom-0 right-0"
  >
    {text}
</Button>
