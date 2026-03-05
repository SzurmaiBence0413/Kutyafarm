export default {
  async getAboutPageData() {
    return {
      hero: {
        title: "About KutyaMarket",
        subtitle:
          "Connecting loving families with their perfect canine companions since 2020",
      },
      mission: {
        title: "Our Mission",
        paragraphs: [
          "At KutyaMarket, we believe every dog deserves a loving home and every family deserves a loyal companion. We are committed to ethical breeding, transparency, and responsible pet ownership.",
          "Our platform connects trusted breeders, verified shelters, and caring dog lovers in one place. We make the process of finding a healthy, happy dog simple and reliable.",
        ],
        image:
          "https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=1200&q=80",
      },
      values: [
        {
          id: 1,
          icon: "bi-heart",
          title: "Compassion",
          text: "Every dog deserves love and safe care from birth to lifelong companionship.",
        },
        {
          id: 2,
          icon: "bi-shield-check",
          title: "Trust",
          text: "Verified breeders and transparent health records for your peace of mind.",
        },
        {
          id: 3,
          icon: "bi-people",
          title: "Community",
          text: "Building supportive networks of dog lovers, owners, and breeders worldwide.",
        },
        {
          id: 4,
          icon: "bi-award",
          title: "Excellence",
          text: "Dedicated to improving standards in every aspect of our veterinary guidance.",
        },
      ],
      story: {
        title: "Our Story",
        paragraphs: [
          "KutyaMarket was founded in 2020 by a group of passionate dog lovers who saw the need for a transparent and ethical dog marketplace.",
          "From our early days as a small community project, we have grown into a trusted platform helping thousands of families find healthy companions.",
          "We remain dedicated to creating meaningful connections between responsible breeders and pet-loving families through care, education, and trust.",
        ],
      },
      impact: [
        { id: 1, value: "10K+", label: "Happy Families" },
        { id: 2, value: "15K+", label: "Dogs Rehomed" },
        { id: 3, value: "500+", label: "Verified Breeders" },
        { id: 4, value: "98%", label: "Satisfaction Rate" },
      ],
      team: {
        title: "Meet Our Team",
        subtitle:
          "Our dedicated team of dog lovers and professionals work around the clock to ensure KutyaMarket remains the trusted marketplace.",
        members: [
          {
            id: 1,
            name: "Sarah Mitchell",
            role: "CEO & Founder",
            bio: "Veterinarian with 15+ years of experience",
            image:
              "https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=700&q=80",
          },
          {
            id: 2,
            name: "James Rodriguez",
            role: "Head of Operations",
            bio: "Former rescue shelter director",
            image:
              "https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=700&q=80",
          },
          {
            id: 3,
            name: "Emma Chen",
            role: "Community Lead",
            bio: "Passionate about connecting families with dogs",
            image: "",
          },
        ],
      },
      community: {
        title: "Join Our Community",
        text: "Whether you are looking for a loyal friend, trusted support, or want to share your love for dogs, KutyaMarket is here to help every step of the way.",
      },
    };
  },
};
