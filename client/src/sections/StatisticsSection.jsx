import React, { useEffect, useState } from 'react';
import { motion } from 'framer-motion';

const stats = [
  { id: 1, target: 569, label: 'Projects Completed' },
  { id: 2, target: 356, label: 'Happy Clients' },
  { id: 3, target: 783, label: 'Cups of Coffee' },
  { id: 4, target: 894, label: 'Lines of Code' },
];

const features = [
  { icon: '⚡', title: 'Expert Team', description: 'Our team consists of certified professionals with years of experience.' },
  { icon: '🔧', title: 'Cutting Edge Technology', description: 'We use the latest tools and frameworks to deliver superior solutions.' },
  { icon: '🛡️', title: '24/7 Support', description: 'Round-the-clock support to ensure your systems run smoothly.' },
  { icon: '🎯', title: 'Custom Solutions', description: 'Tailored solutions that fit your unique business requirements.' },
];

const StatisticsSection = () => {
  const [animatedStats, setAnimatedStats] = useState(stats.map(s => ({ ...s, value: 0 })));

  useEffect(() => {
    const intervals = stats.map((stat, index) => {
      let current = 0;
      const increment = stat.target / 50;
      const timer = setInterval(() => {
        current += increment;
        if (current >= stat.target) {
          current = stat.target;
          clearInterval(timer);
        }
        setAnimatedStats(prev => {
          const copy = [...prev];
          copy[index] = { ...copy[index], value: Math.floor(current) };
          return copy;
        });
      }, 30);
      return timer;
    });
    return () => intervals.forEach(clearInterval);
  }, []);

  return (
    <section className="bg-white py-20">
      <div className="max-w-7xl mx-auto px-6">
        <div className="grid gap-8 md:grid-cols-2 items-start">
          <div className="space-y-6">
            <h2 className="text-3xl md:text-4xl font-bold text-dark-navy mb-4">
              Why Choose Our Solutions
            </h2>
            <div className="space-y-4">
              {features.map((feature, i) => (
                <motion.div
                  key={i}
                  initial={{ x: -10, opacity: 0 }}
                  whileInView={{ x: 0, opacity: 1 }}
                  transition={{ duration: 0.6, delay: i * 0.1 }}
                  viewport={{ once: true }}
                  className="flex items-start space-x-3 text-gray-text"
                >
                  <div className="flex-shrink-0 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-primary" viewBox="0 0 20 20" fill="currentColor">
                      <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                    </svg>
                  </div>
                  <div>
                    <h3 className="font-medium text-dark-navy">{feature.title}</h3>
                    <p className="text-sm">{feature.description}</p>
                  </div>
                </motion.div>
              ))}
            </div>
          </div>

          <div className="space-y-6">
            <h2 className="text-3xl md:text-4xl font-bold text-dark-navy mb-4">
              Our Impact in Numbers
            </h2>
            <div className="grid gap-6 md:grid-cols-2">
              {animatedStats.map((stat) => (
                <motion.div
                  key={stat.id}
                  initial={{ y: 20, opacity: 0 }}
                  whileInView={{ y: 0, opacity: 1 }}
                  transition={{ duration: 0.6, delay: stat.id * 0.1 }}
                  viewport={{ once: true }}
                  className="flex flex-col items-center text-center"
                >
                  <div className="mb-3">
                    <span className="text-5xl font-bold text-primary">{stat.value}</span>
                    <span className="text-xl font-bold text-primary">+</span>
                  </div>
                  <p className="text-sm text-gray-text">{stat.label}</p>
                </motion.div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default StatisticsSection;