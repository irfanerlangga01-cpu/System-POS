import React from 'react';
import { motion } from 'framer-motion';
import { SiWebflow, SiJavascript, SiMongodb, SiReact } from 'react-icons/si';

const services = [
  { id: 1, icon: <SiWebflow size={28} color="#0d5cff" />, title: 'Web Development', description: 'Custom web applications built with modern technologies', isActive: true },
  { id: 2, icon: <SiJavascript size={28} color="#0d5cff" />, title: 'Mobile Apps', description: 'Native and cross-platform mobile solutions', isActive: false },
  { id: 3, icon: <SiMongodb size={28} color="#0d5cff" />, title: 'Cloud Services', description: 'Secure and scalable cloud infrastructure', isActive: false },
  { id: 4, icon: <SiReact size={28} color="#0d5cff" />, title: 'UI/UX Design', description: 'User-centered design and experience', isActive: false },
];

const ServicesSection = () => {
  return (
    <section className="bg-white py-20">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="mb-16 flex flex-col lg:flex-row lg:items-start lg:justify-between gap-8">
          <div className="max-w-lg">
            <span className="text-primary text-xs font-semibold tracking-[0.15em] uppercase mb-3 block">What We Do</span>
            <h2 className="text-3xl md:text-4xl lg:text-[42px] font-bold text-dark-navy leading-[1.15] mb-4">
              We Work Hard<br />Play Hard<br />Explore Creative Mind
            </h2>
          </div>
          <div className="max-w-md text-gray-text text-base leading-relaxed lg:text-right">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
            </p>
          </div>
        </div>

        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
          {services.map((service, i) => (
            <motion.div
              key={service.id}
              initial={{ y: 40, opacity: 0 }}
              whileInView={{ y: 0, opacity: 1 }}
              transition={{ duration: 0.6, delay: i * 0.1 }}
              viewport={{ once: true }}
              className={`group relative flex flex-col items-center p-8 rounded-xl text-center cursor-pointer transition-all duration-400 ${
                service.isActive
                  ? 'bg-primary shadow-card'
                  : 'bg-white border border-border-light hover:-translate-y-2 hover:shadow-card'
              }`}
            >
              <div className={`mb-5 ${service.isActive ? 'text-white' : 'group-hover:text-primary'}`}>
                {service.isActive ? (
                  <div className="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    {service.icon}
                  </div>
                ) : (
                  service.icon
                )}
              </div>
              <h3 className={`text-lg font-semibold mb-3 ${service.isActive ? 'text-white' : 'text-dark-navy group-hover:text-primary'}`}>
                {service.title}
              </h3>
              <p className={`text-sm leading-relaxed ${service.isActive ? 'text-white/80' : 'text-gray-text'}`}>
                {service.description}
              </p>
              <div className={`mt-6 w-9 h-9 rounded-xl flex items-center justify-center border transition-all duration-300 ${
                service.isActive
                  ? 'border-white/30 bg-white/10'
                  : 'border-primary/30 group-hover:bg-primary/10'
              }`}>
                <span className={`text-sm font-bold ${service.isActive ? 'text-white' : 'text-primary'}`}>+</span>
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default ServicesSection;