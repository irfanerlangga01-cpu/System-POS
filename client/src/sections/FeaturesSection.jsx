import React from 'react';
import { motion } from 'framer-motion';
import { Zap, Shield, Cpu } from 'lucide-react';

const features = [
  {
    id: 1,
    icon: <Zap className="w-7 h-7" />,
    title: 'Modern Workflow System',
    description: 'Streamline your operations with our cutting-edge workflow automation tools designed for modern businesses.',
  },
  {
    id: 2,
    icon: <Shield className="w-7 h-7" />,
    title: 'Unified Messaging',
    description: 'Connect with your team and clients through a single unified communication platform with real-time collaboration.',
  },
  {
    id: 3,
    icon: <Cpu className="w-7 h-7" />,
    title: 'Automation Software',
    description: 'Automate repetitive tasks and focus on what matters most with our intelligent automation solutions.',
  },
];

const FeaturesSection = () => {
  return (
<section className="bg-white py-24 relative overflow-hidden">
       <div className="absolute inset-0">
         <div className="absolute top-1/4 -left-1/4 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[80px]" />
         <div className="absolute bottom-1/4 -right-1/4 w-[400px] h-[400px] bg-primary/8 rounded-full blur-[60px]" />
         <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] bg-primary/5 rounded-full blur-[100px]" />
       </div>

       <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
         <motion.div
           initial={{ opacity: 0, y: 30 }}
           whileInView={{ opacity: 1, y: 0 }}
           transition={{ duration: 0.8 }}
           viewport={{ once: true }}
           className="text-center mb-16"
         >
           <span className="inline-block text-primary text-xs font-semibold tracking-[0.15em] uppercase mb-3 bg-primary/10 px-4 py-1.5 rounded-full">
             Core Features
           </span>
           <h2 className="text-3xl md:text-4xl lg:text-[42px] font-bold text-dark-navy leading-[1.2] mb-4">
             We Provide Best IT Solutions
           </h2>
           <p className="text-dark-navy/60 text-base max-w-xl mx-auto">
             Our comprehensive suite of tools and services empowers businesses to thrive in the digital age.
           </p>
         </motion.div>

         <div className="grid gap-8 md:grid-cols-3 max-w-5xl mx-auto">
           {features.map((feature, i) => (
             <motion.div
               key={feature.id}
               initial={{ y: 40, opacity: 0 }}
               whileInView={{ y: 0, opacity: 1 }}
               transition={{ duration: 0.6, delay: i * 0.15 }}
               viewport={{ once: true }}
               className="group relative rounded-2xl bg-white border border-border-light p-8 text-center hover:bg-light-blue hover:border-primary/30 transition-all duration-400 hover:-translate-y-2 shadow-sm hover:shadow-md"
             >
               <div className="w-16 h-16 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center text-primary mb-5 group-hover:bg-primary/20 group-hover:border-primary/40 transition-all duration-300">
                 {feature.icon}
               </div>
               <h3 className="text-lg font-semibold text-dark-navy mb-3">{feature.title}</h3>
               <p className="text-gray-text text-sm leading-relaxed max-w-xs mx-auto">{feature.description}</p>
             </motion.div>
           ))}
         </div>
       </div>
     </section>
  );
};

export default FeaturesSection;