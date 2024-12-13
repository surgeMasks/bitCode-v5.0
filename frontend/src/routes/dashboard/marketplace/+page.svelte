<script lang="ts">
    import { onMount } from 'svelte';
    import api from '$lib/apis/dashboard';
  
    let projects = [
      {
        id: 1,
        name: 'Project One',
        description: 'Description for project one',
        price: 100,
        image: 'https://via.placeholder.com/150'
      },
      {
        id: 2,
        name: 'Project Two',
        description: 'Description for project two',
        price: 200,
        image: 'https://via.placeholder.com/150'
      },
      {
        id: 3,
        name: 'Project Three',
        description: 'Description for project three',
        price: 300,
        image: 'https://via.placeholder.com/150'
      }
    ];
  
    // Fetch projects from your API
    onMount(async () => {
      const response = await api.getProjects();
      if (response.ok) {
        projects = await response.json();
        console.log(projects);
      } else {
        console.error('Failed to fetch projects');
      }
    });
  
    const handlePurchase = (projectId: number) => {
      // You will send the project ID to the backend to initiate payment
      // It will generate a Stripe checkout session and return the session ID
      fetch(`/api/create-checkout-session/${projectId}`, {
        method: 'POST',
      })
      .then((response) => response.json())
      .then((data) => {
        if (data.sessionId) {
          // Redirect to Stripe Checkout page
          window.location.href = `https://checkout.stripe.com/pay/${data.sessionId}`;
        } else {
          console.error('Failed to create checkout session');
        }
      });
    };

  </script>
  
  <style>
    .project-card {
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .project-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }
    .project-image {
      height: 200px;
      object-fit: cover;
    }
    .purchase-button {
      background-color: #1d4ed8;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      transition: background-color 0.2s;
    }
    .purchase-button:hover {
      background-color: #2563eb;
    }
  </style>
  
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    {#each projects as project}
      <div class="project-card bg-white rounded-lg shadow-md p-4">
        <img src={project.image} alt={project.name} class="project-image w-full rounded-md" />
        <h3 class="text-xl font-semibold mt-4">{project.name}</h3>
        <p class="mt-2 text-gray-600">{project.description}</p>
        <p class="mt-4 font-semibold text-lg">${project.price}</p>
        <button
          class="purchase-button mt-4"
          on:click={() => handlePurchase(project.id)}
        >
          Purchase
        </button>
      </div>
    {/each}
  </div>

<main class="p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {#each projects as project}
            <div class="project-card bg-white rounded-lg shadow-md p-4">
                <img src={project.image} alt={project.name} class="project-image w-full rounded-md" />
                <h3 class="text-xl font-semibold mt-4">{project.name}</h3>
                <p class="mt-2 text-gray-600">{project.description}</p>
                <p class="mt-4 font-semibold text-lg">${project.price}</p>
                <button
                    class="purchase-button mt-4"
                    on:click={() => handlePurchase(project.id)}
                >
                    Purchase
                </button>
            </div>
        {/each}
    </div>
</main>
