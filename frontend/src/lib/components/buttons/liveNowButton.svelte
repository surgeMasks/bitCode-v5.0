<script lang="ts">
  import { getZoomLink } from "$lib/handlers/fetchHandlers";
  import LiveIcon from "$lib/images/icons/live.svg";
  import { Button, Spinner } from "flowbite-svelte";
  import { Alert } from "$stores/globalStore";
  import { ZoomMeetingStatus } from "$lib/enums/zoomMeetingStatus";
  
  export let lesson:any ;
  let isResponseLoading = false;
  let isLessonAllowed = lesson.lessonStatus === 'ALLOWED' || lesson.price == 0 || lesson.zoom.approval_type == ZoomMeetingStatus.FREE;

  async function OpenZoomMeeting(){
    isResponseLoading = true;
    try{
          const zoomLink = await getZoomLink(lesson.zoom.id);
          window.open(zoomLink, "_tab"); // Open Zoom link in a new tab
        }
        catch (error){
            Alert.set({message: "Zoom link not available. Try Again", type: 'warning'});
        } finally {
            isResponseLoading = false;
        }
  }
</script>


<Button
  on:click={OpenZoomMeeting}
  class="absolute bottom-6 left-6 animate-pulse w-36 h-10 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-full"
  disabled={!isLessonAllowed || isResponseLoading}
  title={isLessonAllowed ? 'Click to Join live': 'Purchase Lesson to Join'}
  >
  {#if isResponseLoading}
    <Spinner size="6" color="white" />
  {:else}
    <img class="h-6 w-6 mr-2" alt="Live Now Icon" src="{LiveIcon}" />
    Live Now &nbsp
  {/if}
</Button>