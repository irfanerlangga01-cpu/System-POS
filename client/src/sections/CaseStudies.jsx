import React from 'react';
import { motion } from 'framer-motion';

const caseStudies = [
  {
    id: 1,
    image: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=500&w=400&q=80',
    title: 'Enterprise Web Platform',
    description: 'Scalable solution for global corporation',
    category: 'Web Development',
  },
  {
    id: 2,
    image: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=500&w=400&q=80',
    title: 'Mobile App for Healthcare',
    description: 'Patient management and telemedicine',
    category: 'Mobile Development',
  },
  {
    id: 3,
    image: 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=500&w=400&q=80',
    title: 'Cloud Migration Project',
    description: 'AWS infrastructure optimization',
    category: 'Cloud Services',
  },
  {
    id: 4,
    image: 'https://images.unsplash.com/photo-1551434678-e076c223a692?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=500&w=400&q=80',
    title: 'UX/UI Redesign',
    description: 'E-commerce platform transformation',
    category: 'UI/UX Design',
  },
  {
    id: 5,
    image: 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=500&w=400&q=80',
    title: 'Data Analytics Dashboard',
    description: 'Real-time business intelligence',
    category: 'Data Analytics',
  },
  {
    id: 6,
    image: 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=500&w=400&q=80',
    title: 'E-commerce Platform',
    description: 'Full-stack online retail solution',
    category: 'Full Stack Development',
  },
];

const CaseStudies = () => {
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
          <span className="inline-block text-primary text-xs font-semibold tracking-[0.15em] uppercase mb-3 bg-blue-50 px-4 py-1.5 rounded-full">
            Our Portfolio
          </span>
          <h2 className="text-3xl md:text-4xl lg:text-[42px] font-bold text-dark-navy leading-[1.2] mb-4">
            Reads Our Recent<br />Case Studies
          </h2>
          <p className="text-gray-text text-base max-w-xl mx-auto">
            Explore our latest projects showcasing innovative solutions delivered to clients across industries.
          </p>
        </motion.div>

        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          {caseStudies.map((study, i) => (
            <motion.div
              key={study.id}
              initial={{ y: 40, opacity: 0 }}
              whileInView={{ y: 0, opacity: 1 }}
              transition={{ duration: 0.6, delay: i * 0.1 }}
              viewport={{ once: true }}
              className="group relative overflow-hidden rounded-2xl shadow-card hover:shadow-lg transition-all duration-400 hover:-translate-y-2"
            >
              <div className="relative h-64 overflow-hidden">
                <img
                  src={study.image}
                  alt={study.title}
                  className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-dark-navy/80 to-transparent" />
                <span className="absolute top-4 left-4 bg-primary/90 text-white text-xs font-semibold px-3 py-1 rounded-full">
                  {study.category}
                </span>
              </div>
              <div className="absolute bottom-0 left-0 right-0 p-6">
                <h3 className="text-white font-semibold text-lg mb-1">{study.title}</h3>
                <p className="text-white/70 text-sm">{study.description}</p>
              </div>
            </motion.div>
          ))}
        </div>

        <motion.div
          initial={{ opacity: 0 }}
          whileInView={{ opacity: 1 }}
          transition={{ duration: 0.6, delay: 0.4 }}
          viewport={{ once: true }}
          className="text-center mt-10"
        >
          <button className="border-2 border-primary text-primary px-8 py-3 rounded-full font-semibold text-sm hover:bg-primary hover:text-white transition-all duration-300 hover:shadow-lg hover:shadow-primary/25">
            View All Projects →
          </button>
        </motion.div>
      </div>
    </section>
  );
};

export default CaseStudies;