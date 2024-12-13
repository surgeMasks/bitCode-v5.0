<script>
    let menuItems = [
        { name: "Posts", link: "/dashboard/posts" },
        { name: "MarketPlace", link: "/dashboard/marketplace" },
        { name: "Profile", link: "/dashboard/profile" },
        { name: "Logout", link: "/dashboard/auth/logout" }
    ];

    import { onMount } from 'svelte';

    onMount(() => {
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/auth/login';
        }
    });
</script>

<style>
    /* General Styling */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      background-color: #f8f8f8;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .logo {
      font-size: 1.5rem;
      color: #1e7e34;
      font-weight: bold;
    }
    nav ul {
      display: flex;
      list-style: none;
      margin: 0;
      padding: 0;
    }
    nav ul li {
      margin-right: 1.5rem;
      font-size: 1rem;
    }
    nav ul li a {
      text-decoration: none;
      color: inherit;
      cursor: pointer;
    }
    .icons {
      display: flex;
      align-items: center;
    }
    .icons i {
      font-size: 1.5rem;
      margin-left: 1rem;
      cursor: pointer;
    }
    .about-section {
      padding: 2rem;
      text-align: center;
      background-color: #fefefe;
    }
    .about-section h1 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }
    .about-section p {
      font-size: 1.2rem;
      line-height: 1.5;
      color: #666;
      margin-bottom: 2rem;
    }
    .content {
      max-width: 900px;
      margin: 0 auto;
      text-align: left;
    }
    .content h2 {
      font-size: 2rem;
      color: #1e7e34;
      margin-bottom: 1rem;
    }
    .content p {
      font-size: 1rem;
      margin-bottom: 1rem;
      line-height: 1.6;
    }
    .content img {
      width: 100%;
      border-radius: 8px;
    }
</style>

<header>
    <div class="logo">SurgicalMasks</div>
    <nav>
      <ul>
        {#each menuItems as item}
          <li><a href={item.link}>{item.name}</a></li>
        {/each}
      </ul>
    </nav>
    <div class="icons">
      <i class="fa fa-user-circle" aria-hidden="true"></i>
      <i class="fa fa-shopping-cart" aria-hidden="true"></i>
    </div>
</header>

<section class="about-section">
    <h1>Our Platform</h1>
    <p>On our platform, you can buy projects using Stripe. We have integrated Stripe to ensure secure and seamless transactions for all your purchases.</p>
</section>

<div class="content">
    <h2>Why Choose Stripe?</h2>
    <p>
      Stripe is a leading payment processing platform that offers robust security features, ensuring that your transactions are safe and secure. With Stripe, you can easily manage your payments and enjoy a hassle-free experience.
    </p>
    <p>
      Our integration with Stripe allows you to focus on what matters most - your projects. Whether you're buying or selling, Stripe makes the process smooth and efficient.
    </p>
</div>

<!-- Add the slot here -->
<slot></slot>