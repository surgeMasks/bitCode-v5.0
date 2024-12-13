<script lang="ts">
  export let value = '';
  export let placeholder = 'Password';

  let showPassword = false;
</script>

<div class="relative">
    {#if !showPassword}
        <input 
            bind:value
            type="password"
            {placeholder}
            class="input border border-gray-300 rounded w-full px-4 py-2 focus:outline-none focus:border-blue-500" 
            maxlength=15
            required
        />
    {:else}
        <input 
            bind:value
            type='text'
            {placeholder}
            class="input border border-gray-300 rounded w-full px-4 py-2 focus:outline-none focus:border-blue-500" 
            maxlength=15
            required
        />
    {/if}
  <button type="button" class="absolute right-2 top-2"  on:click={() => showPassword = !showPassword}>
    <i class={showPassword ? 'fas fa-eye' : 'fas fa-eye-slash'}></i>
  </button>
</div>