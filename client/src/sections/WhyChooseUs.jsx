import React from 'react';
import { motion } from 'framer-motion';
import { CheckCircle2 } from 'lucide-react';

const features = [
  {
    id: 1,
    icon: '⚡',
    title: 'Expert Team',
    description: 'Our team consists of certified professionals with years of experience in the industry.',
  },
  {
    id: 2,
    icon: '🔧',
    title: 'Cutting Edge Technology',
    description: 'We use the latest tools and frameworks to deliver superior solutions.',
  },
  {
    id: 3,
    icon: '🛡️',
    title: '24/7 Support',
    description: 'Round-the-clock support to ensure your systems run smoothly.',
  },
  {
    id: 4,
    icon: '🎯',
    title: 'Custom Solutions',
    description: 'Tailored solutions that fit your unique business requirements.',
  },
];

const stats = [
  { id: 1, value: 569, label: 'Projects Completed', suffix: '+' },
  { id: 2, value: 356, label: 'Happy Clients', suffix: '+' },
  { id: 3, value: 783, label: 'Cups of Coffee', suffix: '+' },
  { id: 4, value: 894, label: 'Lines of Code', suffix: '+' },
];

const WhyChooseUs = () => {
  return (
    <section className="bg-white py-20">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid lg:grid-cols-2 gap-12 lg:gap-16 items-start">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            viewport={{ once: true }}
          >
            <span className="inline-block text-primary text-xs font-semibold tracking-[0.15em] uppercase mb-3 bg-primary/10 px-4 py-1.5 rounded-full">
              Why Us
            </span>
            <h2 className="text-3xl md:text-4xl lg:text-[42px] font-bold text-dark-navy leading-[1.2] mb-8">
              Why Choose<br />Our Solutions
            </h2>
            <div className="space-y-5">
              {features.map((feature, i) => (
                <motion.div
                  key={feature.id}
                  initial={{ x: -20, opacity: 0 }}
                  whileInView={{ x: 0, opacity: 1 }}
                  transition={{ duration: 0.5, delay: i * 0.1 }}
                  viewport={{ once: true }}
                  className="flex items-start gap-4"
                >
                  <div className="flex-shrink-0 w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary text-lg">
                    {feature.icon}
                  </div>
                  <div>
                    <h3 className="text-base font-semibold text-dark-navy mb-1">{feature.title}</h3>
                    <p className="text-gray-text text-sm leading-relaxed">{feature.description}</p>
                  </div>
                </motion.div>
              ))}
            </div>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8, delay: 0.2 }}
            viewport={{ once: true }}
            className="bg-gradient-to-br from-primary/5 to-light-blue/30 rounded-3xl p-8 sm:p-12 shadow-card"
          >
            <h3 className="text-dark-navy/60 text-xs font-semibold tracking-[0.15em] uppercase mb-8">Our Impact in Numbers</h3>
            <div className="grid grid-cols-2 gap-6">
              {stats.map((stat, i) => (
                <motion.div
                  key={stat.id}
                  initial={{ y: 20, opacity: 0 }}
                  whileInView={{ y: 0, opacity: 1 }}
                  transition={{ duration: 0.6, delay: i * 0.1 }}
                  viewport={{ once: true }}
                  className="text-center p-4 rounded-xl bg-white"
                >
                  <div className="text-4xl sm:text-5xl font-bold text-primary mb-1">
                    {stat.value}{stat.suffix}
                  </div>
                  <p className="text-gray-text text-xs font-medium">{stat.label}</p>
                </motion.div>
              ))}
            </div>
          </motion.div>
        </div>
      </div>
    </section>
  );
};

export default WhyChooseUs;