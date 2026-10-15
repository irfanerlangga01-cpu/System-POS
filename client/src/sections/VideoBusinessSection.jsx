import React from 'react';
import { motion } from 'framer-motion';
import { PlayCircle } from 'lucide-react';

const VideoBusinessSection = () => {
  return (
<section className="relative py-24 overflow-hidden">
      <div
        className="absolute inset-0 bg-cover bg-center"
        style={{
          backgroundImage: "url('https://images.unsplash.com/photo-1553877522-43269d4ea984?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=700&w=1600&q=80')",
        }}
      />
      <div className="absolute inset-0 bg-gradient-to-r from-primary/20 to-primary/5" />

      <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div className="flex flex-col lg:flex-row items-center justify-between gap-12">
          <div className="flex-1 text-center lg:text-left text-dark-navy max-w-2xl">
            <motion.h2
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8 }}
              viewport={{ once: true }}
              className="text-3xl md:text-4xl lg:text-[42px] font-bold mb-6 leading-[1.2]"
            >
              Get Better Solution For Your Business
            </motion.h2>
            <motion.p
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8, delay: 0.2 }}
              viewport={{ once: true }}
              className="text-dark-navy/70 text-base mb-8 max-w-xl"
            >
              We help businesses unlock their full potential with cutting-edge IT solutions and expert consulting.
            </motion.p>

            <motion.div
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8, delay: 0.4 }}
              viewport={{ once: true }}
              className="inline-flex items-center gap-4 bg-white/80 backdrop-blur-sm border border-primary/20 rounded-full px-6 py-3 cursor-pointer hover:bg-white transition-all duration-300 group"
            >
              <div className="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center group-hover:bg-primary/30 transition-colors">
                <PlayCircle className="w-5 h-5 text-primary" />
              </div>
              <span className="text-dark-navy font-semibold text-sm">Watch Video</span>
            </motion.div>
          </div>

          <motion.div
            initial={{ opacity: 0, scale: 0.8 }}
            whileInView={{ opacity: 1, scale: 1 }}
            transition={{ duration: 0.8, delay: 0.3 }}
            viewport={{ once: true }}
            className="relative"
          >
            <div className="w-[340px] h-[480px] rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
              <img
                src="https://images.unsplash.com/photo-1552664730-d307ca884978?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=768&w=540&q=80"
                alt="Business solution"
                className="w-full h-full object-cover"
              />
            </div>
            <div className="absolute -bottom-4 -left-4 w-20 h-20 bg-primary/30 rounded-2xl backdrop-blur-sm border border-white/10" />
            <div className="absolute -top-4 -right-4 w-16 h-16 bg-primary/30 rounded-xl backdrop-blur-sm border border-white/10" />
          </motion.div>
        </div>
      </div>
    </section>
  );
};

export default VideoBusinessSection;