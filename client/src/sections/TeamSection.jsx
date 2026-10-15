import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Linkedin, Twitter, Mail } from 'lucide-react';

const teamMembers = [
  { id: 1, name: 'John Smith', role: 'CEO & Founder', image: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=400&q=80', linkedin: '#', twitter: '#', email: '#' },
  { id: 2, name: 'Sarah Johnson', role: 'CTO', image: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=400&q=80', linkedin: '#', twitter: '#', email: '#' },
  { id: 3, name: 'Michael Chen', role: 'Lead Developer', image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=400&q=80', linkedin: '#', twitter: '#', email: '#' },
  { id: 4, name: 'Emily Davis', role: 'UX Designer', image: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=400&q=80', linkedin: '#', twitter: '#', email: '#' },
  { id: 5, name: 'David Wilson', role: 'Project Manager', image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=400&q=80', linkedin: '#', twitter: '#', email: '#' },
  { id: 6, name: 'Lisa Anderson', role: 'Marketing Director', image: 'https://images.unsplash.com/photo-1494790108755-2616b612b786?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=400&q=80', linkedin: '#', twitter: '#', email: '#' },
];

const TeamSection = () => {
  const [hoveredId, setHoveredId] = useState(null);

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
            Our Team
          </span>
          <h2 className="text-3xl md:text-4xl lg:text-[42px] font-bold text-dark-navy leading-[1.2]">
            Meet Our Exclusive<br />Leadership
          </h2>
        </motion.div>

        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          {teamMembers.map((member, i) => (
            <motion.div
              key={member.id}
              initial={{ y: 40, opacity: 0 }}
              whileInView={{ y: 0, opacity: 1 }}
              transition={{ duration: 0.6, delay: i * 0.1 }}
              viewport={{ once: true }}
              onMouseEnter={() => setHoveredId(member.id)}
              onMouseLeave={() => setHoveredId(null)}
              className={`relative overflow-hidden rounded-2xl shadow-card transition-all duration-400 ${
                hoveredId === member.id ? '-translate-y-2 shadow-lg' : ''
              }`}
            >
              <div className="relative">
                <div className="aspect-[3/4] overflow-hidden">
                  <img
                    src={member.image}
                    alt={member.name}
                    className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                  />
                </div>
                <div className={`absolute inset-0 transition-opacity duration-300 ${hoveredId === member.id ? 'bg-primary/80' : 'bg-transparent'}`} />
                <div className="absolute bottom-0 left-0 right-0 p-5 transform translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                  <div className="flex items-center justify-center gap-3">
                    <a href={member.linkedin} className="w-9 h-9 rounded-full bg-white/90 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors">
                      <Linkedin className="w-4 h-4" />
                    </a>
                    <a href={member.twitter} className="w-9 h-9 rounded-full bg-white/90 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors">
                      <Twitter className="w-4 h-4" />
                    </a>
                    <a href={member.email} className="w-9 h-9 rounded-full bg-white/90 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors">
                      <Mail className="w-4 h-4" />
                    </a>
                  </div>
                </div>
              </div>
              <div className="p-5 text-center">
                <h3 className="text-lg font-semibold text-dark-navy mb-1">{member.name}</h3>
                <p className="text-gray-text text-sm">{member.role}</p>
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default TeamSection;