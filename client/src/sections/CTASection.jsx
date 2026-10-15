import React, { useState } from 'react';
import { motion } from 'framer-motion';

const CTASection = () => {
  return (
    <section className="bg-light-blue py-24 relative overflow-hidden">
       <div className="absolute inset-0">
         <div className="absolute top-0 left-0 w-full h-full" style={{ backgroundImage: 'radial-gradient(circle at 1px 1px, primary 1px, transparent 0)', backgroundSize: '40px 40px' }} />
       </div>

       <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
         <motion.div
           initial={{ opacity: 0, y: 30 }}
           whileInView={{ opacity: 1, y: 0 }}
           transition={{ duration: 0.8 }}
           viewport={{ once: true }}
           className="flex flex-col lg:flex-row items-center justify-between gap-8 text-center lg:text-left"
         >
           <div className="flex-1">
             <h2 className="text-2xl sm:text-3xl md:text-4xl font-bold text-dark-navy leading-[1.3] mb-3">
               Preparing For Your<br />Business Success
             </h2>
             <p className="text-dark-navy/60 text-sm sm:text-base max-w-lg mx-auto lg:mx-0">
               Let's work together to achieve your goals and take your business to the next level with our expert IT solutions.
             </p>
           </div>
           <div className="flex-shrink-0">
             <motion.button
               whileHover={{ scale: 1.05 }}
               whileTap={{ scale: 0.95 }}
               className="bg-primary text-white px-8 py-4 rounded-full font-semibold text-sm hover:bg-primary-dark hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 inline-flex items-center gap-2"
             >
               Get Started Now
               <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                 <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
               </svg>
             </motion.button>
           </div>
         </motion.div>
       </div>
     </section>
   );
};

export default CTASection;