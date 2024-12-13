<script>
  export let text = "Continue";
  export let onClick = () =>{
  };
  export let type = "dark"

</script>

<style>
  .continue-btn {
    height: 55px;
    width: 100%;
    padding: 10px;
    background: linear-gradient(to right, #dc2a0b, #dc2a0b);
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: all 200ms ease-in-out;
    font-size: 20px; 
    will-change: transform;
    box-sizing: border-box;
    box-shadow: 0 0 5px 1px #c23f3f; /* Adjust shadow properties */
  }

  .continue-btn:hover {
    box-shadow: 0 0 10px 2px #c23f3f;
    background: linear-gradient(to right, #dc2a0b, #df3c20);
  }

  .continue-btn:active {
    transform: scale(0.99); /* Apply scale transformation when button is clicked */
    background: linear-gradient(to right, #df3c20, #df3c20);
    box-shadow: 0 0 1px 1px #c23f3f;
  }

  .continue-btn-light {
    height: 55px;
    width: 100%;
    padding: 10px;
    background: linear-gradient(to right, #ebd0cb, rgb(226, 157, 145));
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: all 200ms ease-in-out;
    font-size: 20px; 
    will-change: transform;
    box-sizing: border-box;
    box-shadow: 0 0 5px 1px #bb4646; /* Adjust shadow properties */
  }

  .continue-btn-light:hover {
    box-shadow: 0 0 10px 2px #bd4747;
    background: linear-gradient(to right, #e47460, #dd7b6a);
  }

  .continue-btn-light:active {
    transform: scale(0.99); /* Apply scale transformation when button is clicked */
    background: linear-gradient(to right, #e94d31, #e0482d);
    box-shadow: 0 0 1px 1px #be4545;
  }
</style>

{#if type === "dark"}
  <button type="submit" class="continue-btn" on:click = {onClick}>{text}  </button>
{:else}
  <button type="submit" class="continue-btn-light" on:click = {onClick}>{text}  </button>
{/if}
