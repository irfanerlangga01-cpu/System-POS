import React from 'react';
import { motion } from 'framer-motion';

const services = [
  {
    id: 1,
    image: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=600&q=80',
    title: 'Web Development',
    description: 'Custom web applications built with modern technologies',
  },
  {
    id: 2,
    image: 'https://images.unsplash.com/photo-1512941857-6383e226293d?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=600&q=80',
    title: 'Mobile Apps',
    description: 'Native and cross-platform mobile solutions',
  },
  {
    id: 3,
    image: 'https://images.unsplash.com/photo-1518770660439-4636190af475?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=600&q=80',
    title: 'Cloud Services',
    description: 'Secure and scalable cloud infrastructure',
  },
  {
    id: 4,
    image: 'https://images.unsplash.com/photo-1547658719-da2b51169166?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=600&q=80',
    title: 'UI/UX Design',
    description: 'User-centered design and experience',
  },
  {
    id: 5,
    image: 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=600&q=80',
    title: 'Backend Development',
    description: 'Robust server-side applications and APIs',
  },
  {
    id: 6,
    image: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=600&q=80',
    title: 'Data Analytics',
    description: 'Turn data into actionable insights',
  },
];

const FeaturedServicesGrid = () => {
  return (
    <section className="bg-white py-20">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="text-center mb-14"
        >
          <span className="inline-block text-primary text-xs font-semibold tracking-[0.15em] uppercase mb-3 bg-primary/10 px-4 py-1.5 rounded-full">
            What We Offer
          </span>
          <h2 className="text-3xl md:text-4xl lg:text-[42px] font-bold text-dark-navy leading-[1.2]">
            We Offer Better Solution<br />For Your IT Business
          </h2>
        </motion.div>

        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          {services.map((service, i) => (
            <motion.div
              key={service.id}
              initial={{ y: 40, opacity: 0 }}
              whileInView={{ y: 0, opacity: 1 }}
              transition={{ duration: 0.6, delay: i * 0.1 }}
              viewport={{ once: true }}
              className="bg-white rounded-2xl overflow-hidden shadow-card hover:shadow-lg hover:-translate-y-2 transition-all duration-400 border border-border-light group"
            >
              <div className="relative h-52 overflow-hidden">
                <img
                  src={service.image}
                  alt={service.title}
                  className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent" />
              </div>
              <div className="p-6">
                <h3 className="text-lg font-semibold text-dark-navy mb-2">{service.title}</h3>
                <p className="text-gray-text text-sm leading-relaxed mb-4">{service.description}</p>
                <button className="border border-primary/30 text-primary px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-primary hover:text-white transition-all duration-300">
                  Read More →
                </button>
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default FeaturedServicesGrid;